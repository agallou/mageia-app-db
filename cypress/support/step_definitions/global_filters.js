import { When } from "/usr/local/lib/node_modules/cypress-cucumber-preprocessor/steps";

And(`I click on the {string} filter`, clickedItem => {
  cy.get(`.filterwidget`).contains(clickedItem).click()
})

And(`I click on the {string} filter value`, clickedItem => {
  cy.get(`.widgetcontent div`).contains(clickedItem).click({force: true})
})


And(`I click on more filters`, () => {
  cy.get('#linkmore').click()
})
