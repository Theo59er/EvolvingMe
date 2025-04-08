# My Maven App

This project is a client-server application built using Maven. The client application provides a graphical user interface (GUI) for users to input their weight and mood, while the server application handles data storage and processing.

## Project Structure

```
my-maven-app
├── client
│   ├── src
│   │   ├── main
│   │   │   ├── java
│   │   │   │   └── com
│   │   │   │       └── example
│   │   │   │           └── client
│   │   │   │               └── ClientApp.java
│   │   │   └── resources
│   │   │       └── application.properties
│   │   └── test
│   │       └── java
│   │           └── com
│   │               └── example
│   │                   └── client
│   │                       └── ClientAppTest.java
│   └── pom.xml
├── server
│   ├── src
│   │   ├── main
│   │   │   ├── java
│   │   │   │   └── com
│   │   │   │       └── example
│   │   │   │           └── server
│   │   │   │               └── ServerApp.java
│   │   │   └── resources
│   │   │       └── application.properties
│   │   └── test
│   │       └── java
│   │           └── com
│   │               └── example
│   │                   └── server
│   │                       └── ServerAppTest.java
│   └── pom.xml
├── pom.xml
└── README.md
```

## Getting Started

### Prerequisites

- Java Development Kit (JDK) 11 or higher
- Apache Maven 3.6 or higher

### Installation

1. Clone the repository:
   ```
   git clone <repository-url>
   cd my-maven-app
   ```

2. Build the project:
   ```
   mvn clean install
   ```

### Running the Applications

- To run the server application:
  ```
  cd server
  mvn spring-boot:run
  ```

- To run the client application:
  ```
  cd client
  mvn spring-boot:run
  ```

### Usage

- Open the client application in your browser or desktop environment.
- Enter your weight and mood in the provided fields.
- The client will send this information to the server for processing and storage.

## Client-Server Architecture

The client communicates with the server using HTTP requests. The server processes these requests and manages the data entries. This architecture allows for a clear separation of concerns, with the client focusing on user interaction and the server handling data management.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any suggestions or improvements.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.