Feature: Person
    In order manage persons
    As an API client
    I need to be able to send calls to api endpoints

    Scenario: Successfully create a person
        Given the "Content-Type" request header is "application/json"
        And the request body is:
        """
        {
          "firstName": "John",
          "lastName": "Smith",
          "phone": "123456789"
        }
        """
        When I request "/person" using HTTP POST
        Then the response code is 200

    Scenario: Cannot create a person because without first or last name
        Given the "Content-Type" request header is "application/json"
        And the request body is:
        """
        {
          "firstName": "John"
        }
        """
        When I request "/person" using HTTP POST
        Then the response code is 406

    Scenario: Create person with addresses
        Given the "Content-Type" request header is "application/json"
        And the request body is:
        """
        {
          "firstName": "John",
          "lastName": "Smith",
          "phone": "123456789",
          "addresses": [
            {
              "address": "Mariacka 12/3",
              "city": "Katowice",
              "type": "home"
            }
          ]
        }
        """
        When I request "/person" using HTTP POST
        Then the response code is 200