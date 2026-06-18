<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoodleApiService
{
    protected string $serverUrl;
    protected string $token;

    public function __construct()
    {
        $this->serverUrl = Setting::getValue('moodle_api_url', 'https://lms.topexam.id/webservice/rest/server.php');
        $this->token = Setting::getValue('moodle_api_token', '');
    }

    public function findUserByUsername(string $username): ?int
    {
        $response = Http::asForm()->post($this->serverUrl, [
            'wstoken' => $this->token,
            'wsfunction' => 'core_user_get_users_by_field',
            'moodlewsrestformat' => 'json',
            'field' => 'username',
            'values' => [$username],
        ]);

        $body = $response->json();

        if ($response->successful() && !empty($body) && isset($body[0]['id'])) {
            return (int) $body[0]['id'];
        }

        return null;
    }

    public function createUser(string $username, string $password, string $firstname, string $lastname, string $email): ?int
    {
        $users = [
            [
                'username' => $username,
                'password' => $password,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'auth' => 'manual',
            ]
        ];

        $response = Http::asForm()->post($this->serverUrl, [
            'wstoken' => $this->token,
            'wsfunction' => 'core_user_create_users',
            'moodlewsrestformat' => 'json',
            'users' => $users,
        ]);

        $body = $response->json();

        if ($response->failed()) {
            $errorMsg = $body['error']['message'] ?? json_encode($body);
            Log::warning('Moodle API createUser failed: ' . $errorMsg . ' — trying lookup for username: ' . $username);

            $existingId = $this->findUserByUsername($username);
            if ($existingId) {
                Log::info('Moodle user already exists, using existing ID ' . $existingId . ' - ' . $username);
                return $existingId;
            }

            Log::error('Moodle API createUser failed and user not found: ' . $errorMsg);
            return null;
        }

        if (isset($body[0]['id'])) {
            Log::info('Moodle user created: ID ' . $body[0]['id'] . ' - ' . $username);
            return (int) $body[0]['id'];
        }

        Log::error('Moodle API createUser unexpected response: ' . json_encode($body));
        return null;
    }

    public function enrolUser(int $courseId, int $userId): bool
    {
        $enrolments = [
            [
                'roleid' => 5,
                'userid' => $userId,
                'courseid' => $courseId,
            ]
        ];

        $response = Http::asForm()->post($this->serverUrl, [
            'wstoken' => $this->token,
            'wsfunction' => 'enrol_manual_enrol_users',
            'moodlewsrestformat' => 'json',
            'enrolments' => $enrolments,
        ]);

        $body = $response->json();

        if ($response->failed()) {
            $errorMsg = $body['error']['message'] ?? json_encode($body);
            Log::error('Moodle API enrolUser failed: ' . $errorMsg);
            return false;
        }

        Log::info("Moodle user {$userId} enrolled in course {$courseId}");
        return true;
    }
}
