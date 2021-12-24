import { Given, Then } from "/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps";

Given(`I go to the page {string}`, url => {
  cy.visit(url)
})


Then(`the url should contain {string}`, value => {
  cy.url().should('include', value)
})
