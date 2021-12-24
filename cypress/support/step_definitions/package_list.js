import { When } from "/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps";

And(`I should see a list of {int} packages`, countItems => {
  cy.get('table.packlist tbody > tr').should('have.length', countItems);
})
