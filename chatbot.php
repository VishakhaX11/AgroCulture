<?php
class Chatbot {
    private $api_key;
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }
    public function sendMessage($message) {
        // Send the message to the chatbot API.
        $response = file_get_contents("https://chat.example.com/api/v1/chat?message=$message&api_key=$this->api_key");
        // Return the response from the chatbot API.
        return $response;
    }
    public function receiveMessage() {
        // Receive a message from the chatbot API.
        $response = file_get_contents("https://chat.example.com/api/v1/receive?api_key=$this->api_key");
        // Return the message from the chatbot API.
        return $response;
    }
}
?>