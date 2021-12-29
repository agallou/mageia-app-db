const cucumber = require('/usr/local/lib/node_modules/cypress-cucumber-preprocessor').default

module.exports = (on, config) => {
  on('file:preprocessor', cucumber())
}
