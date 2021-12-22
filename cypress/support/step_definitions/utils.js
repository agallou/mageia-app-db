import { Then } from '/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps'

Then(`I should see {string}`, expectedString => {
  cy.get(`body`).should('contain', expectedString)
})

And(`I click on the link {string}`, clickedItem => {
  cy.contains("a", clickedItem).click()
})
