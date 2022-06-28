# Colorz Exporter : technical test

## Introduction

This application exports data in csv.

## Installation

After cloning the repository from the command-line interface, install all dependencies with Composer :

``$ composer install``

## Exporting data

For testing purpose, we hard-coded the previously given JSON data into the controllers.
When you locally launch the application with (``$ symfony server:start``), you can export data by going to the following routes :
- '/members/csv' to generate a CSV with data from the local superheroes and supervillains (members).
- '/teams/csv' to generate a CSV with overviews of the super squads (teams).
All csv are generated in the ``/public/`` folder.
Each export triggers emails sent to fake addresses, with the csv.

## Future evolutions

Here's a list of additional tasks to make the exporters reliable :
- writing unit tests for the most coherent services, such as the formatters.
- adding a template with a form to upload and process the JSON input; modifying the controllers.
- handling the addition of real email addresses for our event subscriber.
