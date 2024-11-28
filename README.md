# OrderStatus

## Overview

The **OrderStatus** module provides a custom API endpoint in Magento 2 to retrieve the status of an order using its **increment_id**. This API can be accessed anonymously and is ideal for external systems or applications needing to check the status of an order without exposing internal details like **entity_id**.

## Features

- Custom API to retrieve order status by **increment_id**.
- Works with Magento's REST API framework.
- Allows anonymous acces to the API.

## Requerimients

- Magento 2.X
- PHP 8.X

## Instalation

#### 1. Download the module: Clone or download the module and place it inside the app/code/{vendor}/OrderStatus directory in your magento installation.
#### 2. Enable the module: after placing the module in the correct directory, enable it via the magento cli:
```
php bin/magento module:enable {vendor}_OrderStatus
```
#### 3. Run setup upgrade: Execute the following commands to ensure the module is properly registered and the magento system is updated.
```
php bin/magento setup:upgrade
php bin/magento cache:clean
```
#### 4. Compile: if your magento instance is in production mode, you must run:
```
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## Code Structure
- Api/OrderStatusInterface.php: Defines the interface for the API functionality.
- Model/OrderStatus.php: Implements the logic to fetch order status from magento's order repository using **increment_id**.
- etc/webapi.xml: Defines the route for the REST API endpoint.
- etc/module.xml: Module declaration file.
- registration.php: Registers the module within magento.

## Usage
### API Endpoint
The module exposes a REST API endpoint that allows you to retrieve the status of an order by its **increment_id**.

### Endpoint URL:
```
GET <base-url>/rest/V1/order/status/:incrementId
```

### Parameters:
```
IncrementId (string): The increment ID of the order (e.g. 12000026193)
```

### Example:
```
GET http://localhost/rest/V1/order/status/12000026193
```

### Response format:
```
{
    "payment_review"
}
```

### Error handling 
- If no **incrementId** id provided, the API will return a message like:
```
{
  "message": "\"%fieldName\" is required. Enter and try again.",
  "parameters": {
    "fieldName": "incrementId"
  }
}
```
- If the order is not found, you'll get:
```
{
  "message": "Order not found: The entity that was requested doesn't exist. Verify the entity and try again."
}
```

## Licence 
**This module is open-source and free to use under the MIT licence**

## Contact
If you have any qustions or encounter issues, feel free to open an issue on the repository or contact the development team at miguel.briseno.bustos@gmail.com
