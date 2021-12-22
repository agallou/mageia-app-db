import { Given } from "/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps";

Given(`I go to the page {string}`, url => {
  cy.visit(url)
})
