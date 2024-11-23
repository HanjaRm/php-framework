<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

class ContactController
{
    public function __construct(private Request $request, private Response $response)
    {
    }

    // Exercice 1
    public function storeContact()
    {
        $data = json_decode($this->request->getBody(), true);

        if (!isset($data['email'], $data['subject'], $data['message'])) {
            return $this->response->jsonResponse(['error' => 'Invalid request body'], 400);
        }

        $timestamp = time();
        $filename = "{$timestamp}_{$data['email']}.json";
        $filePath = __DIR__ . '/../../var/contacts/' . $filename;

        $contact = [
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'dateOfCreation' => $timestamp,
            'dateOfLastUpdate' => $timestamp,
        ];

        file_put_contents($filePath, json_encode($contact, JSON_PRETTY_PRINT));
        return $this->response->jsonResponse(['file' => $filename], 201);
    }

    // Exercice 2
    public function getAllContacts()
    {
        $directory = __DIR__ . '/../../var/contacts/';
        $files = array_diff(scandir($directory), ['.', '..']);
        $contacts = [];

        foreach ($files as $file) {
            $contacts[] = json_decode(file_get_contents($directory . $file), true);
        }

        return $this->response->jsonResponse($contacts, 200);
    }

    // Exercice 3
    public function getContact($filename)
    {
        $filePath = __DIR__ . '/../../var/contacts/' . $filename;

        if (!file_exists($filePath)) {
            return $this->response->jsonResponse(['error' => 'Contact not found'], 404);
        }

        $contact = json_decode(file_get_contents($filePath), true);
        return $this->response->jsonResponse($contact, 200);
    }


    // Exercice 4
    public function updateContact($filename)
    {
        $filePath = __DIR__ . '/../../var/contacts/' . $filename;

        if (!file_exists($filePath)) {
            return $this->response->jsonResponse(['error' => 'Contact not found'], 404);
        }

        $data = json_decode($this->request->getBody(), true);
        $allowedKeys = ['email', 'subject', 'message'];
        $updated = false;

        $contact = json_decode(file_get_contents($filePath), true);

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedKeys)) {
                $contact[$key] = $value;
                $updated = true;
            } else {
                return $this->response->jsonResponse(['error' => 'Invalid field: ' . $key], 400);
            }
        }

        if ($updated) {
            $contact['dateOfLastUpdate'] = time();
            file_put_contents($filePath, json_encode($contact, JSON_PRETTY_PRINT));
        }

        return $this->response->jsonResponse($contact, 200);
    }

    // Exercice 5
    public function deleteContact($filename)
    {
        $filePath = __DIR__ . '/../../var/contacts/' . $filename;

        if (!file_exists($filePath)) {
            return $this->response->jsonResponse(['error' => 'Contact not found'], 404);
        }

        unlink($filePath);
        return $this->response->jsonResponse([], 204);
    }
}
