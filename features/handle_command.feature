Feature: Handle command

  Scenario: Successfully handle command
    When I run command "command-bus:successful-command --no-interaction"
#    Then command should end successfully
     And the output should be
          """
          The tests\Clearcode\CommandBusConsole\CommandBus\SuccessfulCommand executed with success.
          """

  Scenario: Unsuccessfully handle command
    When I run command "command-bus:unsuccessful-command --no-interaction"
    Then command should end unsuccessfully
     And the output should be
          """
          Unsuccessful command execution.
          """

  Scenario: Successfully handle command with argument
    When I run command "command-bus:command-with-argument --no-interaction --id=1234"
    Then command should end successfully
     And the output should be
          """
          The tests\Clearcode\CommandBusConsole\CommandBus\CommandWithArgument executed with success.
          """

  Scenario: Unsuccessfully handle command with argument if argument is missing
    When I run command "command-bus:command-with-argument --no-interaction"
    Then command should end unsuccessfully

  Scenario: Unsuccessfully handle command with argument if argument has wrong name
    When I run command "command-bus:command-with-argument --no-interaction --badName=1234"
    Then command should end unsuccessfully

  Scenario: Successfully handle command with argument in interactive mode
    When I run command "command-bus:command-with-argument" and provide as input
        """
        1234[enter]
        """
#    Then command should end successfully
     And the output should contain
          """
          The tests\Clearcode\CommandBusConsole\CommandBus\CommandWithArgument executed with success.
          """