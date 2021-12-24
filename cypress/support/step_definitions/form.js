import { When } from "/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps";

When(`I fill in {string} with {string}`, (inpuName, typedValue) => {
  cy.get('input[name="' + inpuName + '"]').type(typedValue);
})

And(`I click on the button {string}`, clickedItem => {
  cy.get(`body`).contains(clickedItem).click()
})

And(`I click on the package search button`, clickedItem => {
  cy.get('#search-page input[type=submit]').click()
})

When(`I fill in the search package field with {string}`, (typedValue) => {
  cy.get('#search-page input[name=t_search]').type(typedValue);
})
