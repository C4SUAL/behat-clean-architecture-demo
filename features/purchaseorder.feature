Feature: Create Purchase Order
  In order to reorder stock for a product
  As an administrator
  I need to create a purchase order.

  Rules:
  - Prompt to create when stock is greater than reorder level
  - Reorder qty must be equal to or greater than supplier's min order qty
  - Reorder amount must be divisible by supplier's ordering UOM
  - Final stock should be less than or equal to locations max stock qty

  Background:
    Given I have suppliers:
      """
      Supplier One
      Supplier Two
      Supplier Three
      Supplier Four
      """
    And the current till location is:
      """
      12 Waskerley Way
      Consett
      DH8 5YH
      """

  Scenario: low stock threshold has been reached
    Given that I have product "shotgun ammo"
    And the product has primary supplier "Supplier One" with cost 18
    And there are 10 in stock
    And the reorder level is 10
    And my target stock level is 80
    When I create a purchase order
    Then the product "shotgun ammo" should have an order quantity of 70

  Scenario: return the primary supplier for a product
    Given that I have product "shotgun ammo"
    And the product has supplier "Supplier Two" with cost 21
    And the product has primary supplier "Supplier One" with cost 18
    When I fetch the primary supplier
    Then the product supplier should be "Supplier One"
    And the supplier price should be 18

  Scenario: the primary supplier will be chosen by default when two or more suppliers exist for a product
    Given that I have product "shotgun ammo"
    And the product has primary supplier "Supplier One" with cost 18
    And the product has supplier "Supplier Two" with cost 21
    When I create a purchase order
    Then the supplier should be "Supplier One"
    And the product price should be 18

  Scenario: order quantity must be greater or equal to supplier's minimum order qty
    Given that I have product "shotgun ammo"
    And the product has primary supplier "Supplier One"
    And supplier "Supplier One" has "cost" 18
    And supplier "Supplier One" has "min order" 100
    When I create a purchase order
    Then the product "shotgun ammo" should have an order quantity greater or equal to 100

  Scenario Outline: order quantity must be an increment of the supplier's ordering UOM
    Examples:
      | currentStock | targetStock | cost | minOrder | orderingUOM | orderQty |
      | 40           | 250         | 18   | 200      | 10          | 210      |
      | 40           | 250         | 18   | 200      | 25          | 225      |
      | 10           | 100         | 18   | 10       | 10          | 90       |
    Given that I have product "shotgun ammo"
    And there are <currentStock> in stock
    And the reorder level is 15
    And my target stock level is <targetStock>
    And the product has primary supplier "Supplier One"
    And supplier "Supplier One" has "cost" <cost>
    And supplier "Supplier One" has "min order" <minOrder>
    And supplier "Supplier One" has "ordering UOM" <orderingUOM>
    When I create a purchase order
    Then the product "shotgun ammo" should have an order quantity of <orderQty>
    And the product "shotgun ammo" should have an order quantity greater or equal to <minOrder>

  Scenario: when given products I want to create one or more purchase orders, one for each unique primary supplier
    Given I have products:
     | id | name          | supplier      | primary |
     | 1  | Eley shells   | Supplier One  | 1       |
     | 2  | Gamebore ammo | Supplier Two  | 1       |
     | 3  | Laser Scope   | Supplier Three| 1       |
     | 4  | Hull shells   | Supplier Two  | 1       |
    When I create purchase orders
    Then it should return 3 purchase orders
    And purchase order for supplier "Supplier One" contains items:
      """
      Eley shells
      """
    And purchase order for supplier "Supplier Two" contains items:
      """
      Gamebore ammo
      Hull shells
      """
    And purchase order for supplier "Supplier Three" contains items:
      """
      Laser scope
      """

  Scenario: the default shipping, billing and supplier addresses should be set as the chosen location,
    current user's till location, and supplier address respectively.
    Given that I have product "Supplier Four"
    And the product has primary supplier "Supplier Four" with cost 12
    And I have a location:
      """
      Test Store
      St Nicholas Square
      Newcastle upon Tyne
      NE1 2TT
      """
    And the current till location is:
      """
      Head Office
      12 Waskerley Way
      Consett
      DH8 5YH
      """
    And the supplier address is:
      """
      Supplier Four
      1 Logie Baird Way
      Hull
      HU1 3RQ
      """
    When I create a purchase order
    Then the shipping address should be:
      """
      St Nicholas Square
      Newcastle upon Tyne
      NE1 2TT
      """
    And the billing address should be:
      """
      12 Waskerley Way
      Consett
      DH8 5YH
      """
    And the supplier address should be:
      """
      1 Logie Baird Way
      Hull
      HU1 3RQ
      """
    And the status should be "Pending"

  Scenario: try to create a purchase order when the product has no primary supplier
    Given that I have product "Shotgun ammo"
    When I create a purchase order
    Then a message should be shown
    And purchase order count should be 0