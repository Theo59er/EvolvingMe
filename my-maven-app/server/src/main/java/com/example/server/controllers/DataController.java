package com.example.server.controllers;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class DataController {

    @GetMapping("/api/data")
    public String getData() {
        return "{\"message\": \"Hello from the server!\"}";
    }
}