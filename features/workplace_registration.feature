Feature: Workplace registration
  As a workplace representative
  I want to register, login and reset my password
  So I can manage my workplace's offers

  Scenario: Workplace representative registers, logs out and then in again
    Given I go to "registrering"
    And I fill in "workplace[name]" with "Test workplace"
    And I fill in "workplace[employees]" with "56"
    And I fill in "workplace[address]" with "Stora varvsgatan 6"
    And I fill in "user[name]" with "Test User"
    And I fill in "user[email]" with "test.user@testworkplace.se"
    And I fill in "user[phone]" with "040-123456"
    And I fill in "user[password]" with "passWord"
    And I fill in "user[password_confirmation]" with "passWord"
    And I press "Registrera arbetsplats"
    Then I should be logged in
    Given I go to "logout"
    Then I should be logged out
    Given I go to "login"
    And I fill in "email" with "test.user@testworkplace.se"
    And I fill in "password" with "passWord"
    And I press "Logga in"
    Then I should be logged in

  Scenario: Workplace representative registers with excess whitespace in fields and gets them trimmed
    Given I go to "registrering"
    And I fill in "workplace[name]" with " Test workplace "
    And I press "Registrera arbetsplats"
    Then the "workplace[name]" field should contain "Test workplace"

  Scenario: Workplace representative registers with excess whitespace in occupations and gets them trimmed
    Given I go to "registrering"
    And I fill in "workplace[occupations]" with " bagare, Art Director , copywriter "
    And I press "Registrera arbetsplats"
    Then the "workplace[occupations]" field should not contain " bagare, Art Director , copywriter "