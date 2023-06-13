<?php

// Database configuration
$host = 'localhost';
$username = 'id20895619_johnrey';
$password = 'Arifureta_09';
$database = 'id20895619_myjoy';

// Function to establish a database connection
function getConnection()
{
    global $host, $username, $password, $database;
    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_errno) {
        die("Failed to connect to MySQL: " . $conn->connect_error);
    }
    return $conn;
}

// Function to add a product order to the database
function addProductOrder($productName, $quantity, $price)
{
    $conn = getConnection();

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO orders (product_name, quantity, price) VALUES (?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("sii", $productName, $quantity, $price);

    // Execute the statement
    $stmt->execute();

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}

// Function to fetch the items in the cart from the database
function getCartItems()
{
    $conn = getConnection();

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT product_name, quantity, price FROM orders");

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($productName, $quantity, $price);

    // Fetch the results into an array
    $cartItems = array();
    while ($stmt->fetch()) {
        $cartItems[] = array(
            'product_name' => $productName,
            'quantity' => $quantity,
            'price' => $price
        );
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    return $cartItems;
}

// Function to calculate the total price of the items in the cart
function calculateTotalPrice($cartItems)
{
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['quantity'] * $item['price'];
    }
    return $totalPrice;
}

?>
