# Joke API Project

Symfony 5 based RESTful API that allows users to anonymously create & read jokes.

## Installation

### Requirement 

Docker version 19.03.12

docker-compose version 1.26.2

```
git clone https://github.com/chamilsanjeewa/borrowworks.git

cd BorrowWorks

cd docker

docker-compose up
```

## Compose

### Database (SQLite)
### PHP -PHP 7.4.8 (PHP-FPM)
### Webserver (Nginx)



_______________

All Set, Now you can access the API in [http://localhost](http://localhost).



## Swagger
Download the [swagger file](/swagger.yml).
```yml
swagger: '2.0'
info:
  version: '1.0'
  title: Borrowworks API
  contact: {}
host: localhost
basePath: /
schemes:
- http
consumes:
- application/json
produces:
- application/json
paths:
  /jokes/{id}:
    get:
      description: Get a joke by ID
      summary: Get a joke by ID
      tags:
      - Joke API
      deprecated: false
      produces:
      - application/json
      parameters: 
      - name: "id"
        in: "path"
        description: "JokeId that need to be fetch"
        required: true
        type: "integer"
      responses:
        200:
          description: ''
          schema:
            $ref: '#/definitions/Joke'
          examples:
            application/json:
              id: 1
              name: Joke 0
              content: 'Content Content Content Content Content Content Content Content Content Content Content '
          headers: {}
        404:
          description: invalid Joke id
          schema: {}
    put:
      description: Edit joke
      summary: Edit joke
      tags:
      - Joke API
      operationId: Editjoke
      deprecated: false
      produces:
      - application/json
      parameters:
      - name: "id"
        in: "path"
        description: "JokeId that need to be updated"
        required: true
        type: "integer"

      - name: Body
        in: body
        required: true
        schema:
          $ref: '#/definitions/Joke'
      responses:
        200:
          description: ''
          schema:
            $ref: '#/definitions/Joke'
          examples:
            application/json:
              id: 99
              name: My joke Updated name
              content: JMy joke Updated content
          headers: {}
    delete:
      description: Delete a joke
      summary: Delete a joke
      tags:
      - Joke API
      operationId: Deleteajoke
      deprecated: false
      produces:
      - application/json
      parameters:     
      - name: "id"
        in: "path"
        description: "JokeId that need to be deleted"
        required: true
        type: "integer"
      responses:
        204:
          description: ''
          schema:
            type: object
          headers: {}
        404:
          description: invalid Joke id
          schema: {}
  /jokes:
    post:
      description: Create a joke
      summary: Create a joke
      tags:
      - Joke API
      operationId: Createajoke
      deprecated: false
      produces:
      - application/json
      parameters:
      - name: Body
        in: body
        required: true
        schema:
          $ref: '#/definitions/Joke'
      responses:
        201:
          description: ''
          schema:
            $ref: '#/definitions/Joke'
          examples:
            application/json:
              id: 101
              name: My First Joke
              content: Joke content
          headers: {}
    get:
      description: Get a list of jokes with pagination
      summary: Get a list of jokes with pagination
      tags:
      - Joke API
      operationId: JokeList
      deprecated: false
      produces:
      - application/json
      parameters:
      - name: page-size
        in: query
        required: true
        type: integer
        format: int32
      - name: page
        in: query
        required: true
        type: integer
        format: int32
      responses:
        200:
          description: ''
          schema:
            $ref: '#/definitions/Getalistofjokeswithpagination'
          examples:
            application/json:
              jokes:
              - id: 1
                name: Joke 0
                content: 'Content Content Content Content Content Content Content Content Content Content Content '
              - id: 2
                name: Joke 1
                content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
              - id: 3
                name: Joke 2
                content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
              - id: 4
                name: Joke 3
                content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
              - id: 5
                name: Joke 4
                content: 'Content Content Content Content Content Content Content Content Content Content '
              - id: 6
                name: Joke 5
                content: 'Content Content Content Content Content Content Content '
              - id: 7
                name: Joke 6
                content: 'Content Content Content Content Content Content Content '
              - id: 8
                name: Joke 7
                content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
              - id: 9
                name: Joke 8
                content: 'Content Content Content Content Content Content Content Content '
              - id: 10
                name: Joke 9
                content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
              totalItems: 101
          headers: {}
  /jokes/random-joke:
    get:
      description: Get a random joke
      summary: Get a random joke
      tags:
      - Joke API
      operationId: Getarandomjoke
      deprecated: false
      produces:
      - application/json
      parameters: []
      responses:
        200:
          description: ''
          schema:
            $ref: '#/definitions/Joke'
          examples:
            application/json:
              id: 51
              name: Joke 50
              content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
          headers: {}
definitions:
  Joke:
    title: Joke
    example:
      id: 1
      name: Joke 0
      content: 'Content Content Content Content Content Content Content Content Content Content Content '
    type: object
    properties:
      id:
        type: integer
        format: int32
      name:
        type: string
      content:
        type: string
    required:
    - id
    - name
    - content
 
 
  Getalistofjokeswithpagination:
    title: JokeList
    example:
      jokes:
      - id: 1
        name: Joke 0
        content: 'Content Content Content Content Content Content Content Content Content Content Content '
      - id: 2
        name: Joke 1
        content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
      - id: 3
        name: Joke 2
        content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
      - id: 4
        name: Joke 3
        content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
      - id: 5
        name: Joke 4
        content: 'Content Content Content Content Content Content Content Content Content Content '
      - id: 6
        name: Joke 5
        content: 'Content Content Content Content Content Content Content '
      - id: 7
        name: Joke 6
        content: 'Content Content Content Content Content Content Content '
      - id: 8
        name: Joke 7
        content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
      - id: 9
        name: Joke 8
        content: 'Content Content Content Content Content Content Content Content '
      - id: 10
        name: Joke 9
        content: 'Content Content Content Content Content Content Content Content Content Content Content Content Content Content Content '
      totalItems: 101
    type: object
    properties:
      jokes:
        type: array
        items:
          $ref: '#/definitions/Joke'
      totalItems:
        type: integer
        format: int32
    required:
    - jokes
    - totalItems
  
tags:
- name: Joke API
  description: 'RESTful API that allows users to anonymously create & read jokes.'