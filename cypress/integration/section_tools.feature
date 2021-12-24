Feature: Tools

  Scenario: I can go to the versions comparaison page

    Given I go to the page "/"
    When I click on the link "Versions comparison"
    Then I should see "This page compares the packages present in Latest stable"

  Scenario: I can go to the QA updates page

    Given I go to the page "/"
    When I click on the link "QA Updates"
    Then I should see "QA team waiting for packager feedback"

    # Il a des erreurs JS sur cette page, on ajoute donc pas de test pour le moment
#  Scenario: I can go to the release blockers page
#
#    Given I go to the page "/"
#    When I click on the link "Release blockers for Mga 8"
#    Then I should see "This page lists all bug reports that have been marked as release blockers"

  Scenario: I can go to the Intended for page

    Given I go to the page "/"
    When I click on the link "Intended for Mga 8"
    Then I should see "This page lists all bug reports that have been marked as intented for next release, except release blockers"

# Il a des erreurs JS sur cette page, on ajoute donc pas de test pour le moment
#  Scenario: I can go to the High priority page
#
#    Given I go to the page "/"
#    When I click on the link "High priority for Mga 8"
#    Then I should see "This page lists all bug reports that have been marked with a high priority"
