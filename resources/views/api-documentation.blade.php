<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Portal Document API Documentation</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui.css" />
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }
        *, *:before, *:after {
            box-sizing: inherit;
        }
        body {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.11.0/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const spec = {
                "openapi": "3.0.0",
                "info": {
                    "title": "Web Portal Document API",
                    "version": "1.0.0",
                    "description": "API documentation for Web Portal Document Backend"
                },
                "servers": [
                    {
                        "url": "{{ url('/api') }}",
                        "description": "API Server"
                    }
                ],
                "paths": {
                    "/login": {
                        "post": {
                            "tags": ["Authentication"],
                            "summary": "Authenticate user and generate token",
                            "requestBody": {
                                "required": true,
                                "content": {
                                    "application/json": {
                                        "schema": {
                                            "type": "object",
                                            "required": ["email", "password"],
                                            "properties": {
                                                "email": {
                                                    "type": "string",
                                                    "format": "email",
                                                    "example": "admin@example.com"
                                                },
                                                "password": {
                                                    "type": "string",
                                                    "format": "password",
                                                    "example": "password"
                                                }
                                            }
                                        }
                                    }
                                }
                            },
                            "responses": {
                                "200": {
                                    "description": "Login successful",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "message": {
                                                        "type": "string",
                                                        "example": "Login successful"
                                                    },
                                                    "user": {
                                                        "type": "object",
                                                        "properties": {
                                                            "id": {"type": "integer", "example": 1},
                                                            "name": {"type": "string", "example": "System Admin"},
                                                            "email": {"type": "string", "format": "email", "example": "admin@example.com"},
                                                            "department_id": {"type": "integer", "example": 1},
                                                            "role_id": {"type": "integer", "example": 1}
                                                        }
                                                    },
                                                    "token": {
                                                        "type": "string",
                                                        "example": "1|abc123..."
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                                "401": {
                                    "description": "Invalid credentials",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "message": {
                                                        "type": "string",
                                                        "example": "The provided credentials do not match our records."
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/user": {
                        "get": {
                            "tags": ["Authentication"],
                            "summary": "Get authenticated user details",
                            "security": [{"bearerAuth": []}],
                            "responses": {
                                "200": {
                                    "description": "User details retrieved successfully",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "user": {
                                                        "type": "object",
                                                        "properties": {
                                                            "id": {"type": "integer", "example": 1},
                                                            "name": {"type": "string", "example": "System Admin"},
                                                            "email": {"type": "string", "format": "email", "example": "admin@example.com"},
                                                            "department": {
                                                                "type": "object",
                                                                "properties": {
                                                                    "id": {"type": "integer", "example": 1},
                                                                    "name": {"type": "string", "example": "Human Resources"}
                                                                }
                                                            },
                                                            "role": {
                                                                "type": "object",
                                                                "properties": {
                                                                    "id": {"type": "integer", "example": 1},
                                                                    "name": {"type": "string", "example": "Super Admin"}
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                                "401": {
                                    "description": "Unauthenticated",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "message": {
                                                        "type": "string",
                                                        "example": "Unauthenticated."
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    "/logout": {
                        "post": {
                            "tags": ["Authentication"],
                            "summary": "Logout user and invalidate token",
                            "security": [{"bearerAuth": []}],
                            "responses": {
                                "200": {
                                    "description": "Logout successful",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "message": {
                                                        "type": "string",
                                                        "example": "Logout successful"
                                                    }
                                                }
                                            }
                                        }
                                    }
                                },
                                "401": {
                                    "description": "Unauthenticated",
                                    "content": {
                                        "application/json": {
                                            "schema": {
                                                "type": "object",
                                                "properties": {
                                                    "message": {
                                                        "type": "string",
                                                        "example": "Unauthenticated."
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                },
                "components": {
                    "securitySchemes": {
                        "bearerAuth": {
                            "type": "http",
                            "scheme": "bearer",
                            "bearerFormat": "JWT"
                        }
                    }
                }
            };

            SwaggerUIBundle({
                url: '',
                spec: spec,
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout"
            });
        };
    </script>
</body>
</html>
