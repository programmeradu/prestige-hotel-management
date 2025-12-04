<?php
// This script fixes the Paystack module hooks for QloApps compatibility using direct SQL
// No PrestaShop/QloApps framework dependencies

// Database connection settings - MODIFY THESE TO MATCH YOUR CONFIGURATION
$db_host = 'localhost';     // Your database host
$db_name = 'hotel';              // Your database name
$db_user = 'hotel';              // Your database username
$db_pass = 'Sammyone@1';              // Your database password
$db_prefix = 'qlooo_';      // Your database table prefix

// Connect to database
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to database successfully<br>";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the module ID
try {
    $stmt = $db->prepare("SELECT id_module FROM {$db_prefix}module WHERE name = 'paystack'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        die('Paystack module not found in database. Please install it first.');
    }
    
    $id_module = $result['id_module'];
    echo "Paystack module ID: $id_module<br>";
} catch(PDOException $e) {
    die("Error getting module ID: " . $e->getMessage());
}

// Check if module is active
try {
    $stmt = $db->prepare("SELECT active FROM {$db_prefix}module WHERE id_module = :id_module");
    $stmt->bindParam(':id_module', $id_module);
    $stmt->execute();
    $active = $stmt->fetchColumn();
    
    if (!$active) {
        // Activate the module
        $stmt = $db->prepare("UPDATE {$db_prefix}module SET active = 1 WHERE id_module = :id_module");
        $stmt->bindParam(':id_module', $id_module);
        if ($stmt->execute()) {
            echo "Module activated successfully.<br>";
        } else {
            echo "Failed to activate module.<br>";
        }
    } else {
        echo "Module is already active.<br>";
    }
} catch(PDOException $e) {
    echo "Error checking/updating module status: " . $e->getMessage() . "<br>";
}

// Get default shop ID
try {
    $stmt = $db->prepare("SELECT id_shop FROM {$db_prefix}shop ORDER BY id_shop ASC LIMIT 1");
    $stmt->execute();
    $default_shop_id = $stmt->fetchColumn();
    
    if (!$default_shop_id) {
        $default_shop_id = 1; // Fallback to default
    }
    
    echo "Using default shop ID: $default_shop_id<br>";
} catch(PDOException $e) {
    echo "Error getting default shop ID: " . $e->getMessage() . "<br>";
    $default_shop_id = 1; // Fallback to default
}

// List of hooks needed for payment modules in QloApps
$hooks = array(
    'paymentOptions',
    'displayPaymentReturn',
    'displayPayment',  // For QloApps compatibility
    'payment',         // For QloApps compatibility
    'displayPaymentTop',
    'displayOrderConfirmation',
    'actionPaymentConfirmation'
);

// Register hooks
foreach ($hooks as $hook_name) {
    try {
        // Check if hook exists
        $stmt = $db->prepare("SELECT id_hook FROM {$db_prefix}hook WHERE name = :hook_name");
        $stmt->bindParam(':hook_name', $hook_name);
        $stmt->execute();
        $hook_id = $stmt->fetchColumn();
        
        if (!$hook_id) {
            echo "Hook '$hook_name' does not exist in database. Creating it...<br>";
            
            // Create the hook
            $stmt = $db->prepare("INSERT INTO {$db_prefix}hook (name, title, description, position) 
                    VALUES (:name, :title, :description, 1)");
            $stmt->bindParam(':name', $hook_name);
            $stmt->bindParam(':title', $hook_name);
            $description = "Hook for $hook_name";
            $stmt->bindParam(':description', $description);
            
            if ($stmt->execute()) {
                $hook_id = $db->lastInsertId();
                echo "Hook '$hook_name' created with ID: $hook_id<br>";
            } else {
                echo "Failed to create hook '$hook_name'.<br>";
                continue;
            }
        }
        
        // Check if module is already hooked (using composite key)
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$db_prefix}hook_module 
                WHERE id_module = :id_module AND id_hook = :id_hook AND id_shop = :id_shop");
        $stmt->bindParam(':id_module', $id_module);
        $stmt->bindParam(':id_hook', $hook_id);
        $stmt->bindParam(':id_shop', $default_shop_id);
        $stmt->execute();
        $is_hooked = $stmt->fetchColumn() > 0;
        
        if (!$is_hooked) {
            // Get max position
            $stmt = $db->prepare("SELECT MAX(position) FROM {$db_prefix}hook_module WHERE id_hook = :id_hook");
            $stmt->bindParam(':id_hook', $hook_id);
            $stmt->execute();
            $position = $stmt->fetchColumn();
            $position = $position ? $position + 1 : 1;
            
            // Hook the module
            $stmt = $db->prepare("INSERT INTO {$db_prefix}hook_module (id_module, id_hook, id_shop, position) 
                    VALUES (:id_module, :id_hook, :id_shop, :position)");
            $stmt->bindParam(':id_module', $id_module);
            $stmt->bindParam(':id_hook', $hook_id);
            $stmt->bindParam(':id_shop', $default_shop_id);
            $stmt->bindParam(':position', $position);
            
            if ($stmt->execute()) {
                echo "Module hooked to '$hook_name' successfully.<br>";
            } else {
                echo "Failed to hook module to '$hook_name'.<br>";
            }
        } else {
            echo "Module is already hooked to '$hook_name'.<br>";
        }
    } catch(PDOException $e) {
        echo "Error processing hook '$hook_name': " . $e->getMessage() . "<br>";
    }
}

// Check if we need to register for specific shop
try {
    $stmt = $db->prepare("SELECT id_shop FROM {$db_prefix}shop");
    $stmt->execute();
    $shops = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($shops) > 1) {
        echo "<br>Multiple shops detected. Ensuring module is enabled for all shops...<br>";
        
        foreach ($shops as $shop) {
            $id_shop = $shop['id_shop'];
            
            // Skip the default shop as we've already processed it
            if ($id_shop == $default_shop_id) {
                continue;
            }
            
            // Check if module is enabled for this shop
            $stmt = $db->prepare("SELECT id_module FROM {$db_prefix}module_shop 
                    WHERE id_module = :id_module AND id_shop = :id_shop");
            $stmt->bindParam(':id_module', $id_module);
            $stmt->bindParam(':id_shop', $id_shop);
            $stmt->execute();
            $is_enabled = $stmt->fetchColumn();
            
            if (!$is_enabled) {
                // Enable module for this shop
                $stmt = $db->prepare("INSERT INTO {$db_prefix}module_shop (id_module, id_shop) 
                        VALUES (:id_module, :id_shop)");
                $stmt->bindParam(':id_module', $id_module);
                $stmt->bindParam(':id_shop', $id_shop);
                
                if ($stmt->execute()) {
                    echo "Module enabled for shop ID: $id_shop<br>";
                } else {
                    echo "Failed to enable module for shop ID: $id_shop<br>";
                }
            } else {
                echo "Module is already enabled for shop ID: $id_shop<br>";
            }
            
            // Register hooks for this shop too
            foreach ($hooks as $hook_name) {
                try {
                    // Get hook ID
                    $stmt = $db->prepare("SELECT id_hook FROM {$db_prefix}hook WHERE name = :hook_name");
                    $stmt->bindParam(':hook_name', $hook_name);
                    $stmt->execute();
                    $hook_id = $stmt->fetchColumn();
                    
                    if (!$hook_id) {
                        continue; // Skip if hook doesn't exist
                    }
                    
                    // Check if module is already hooked for this shop
                    $stmt = $db->prepare("SELECT COUNT(*) FROM {$db_prefix}hook_module 
                            WHERE id_module = :id_module AND id_hook = :id_hook AND id_shop = :id_shop");
                    $stmt->bindParam(':id_module', $id_module);
                    $stmt->bindParam(':id_hook', $hook_id);
                    $stmt->bindParam(':id_shop', $id_shop);
                    $stmt->execute();
                    $is_hooked = $stmt->fetchColumn() > 0;
                    
                    if (!$is_hooked) {
                        // Get max position
                        $stmt = $db->prepare("SELECT MAX(position) FROM {$db_prefix}hook_module WHERE id_hook = :id_hook");
                        $stmt->bindParam(':id_hook', $hook_id);
                        $stmt->execute();
                        $position = $stmt->fetchColumn();
                        $position = $position ? $position + 1 : 1;
                        
                        // Hook the module
                        $stmt = $db->prepare("INSERT INTO {$db_prefix}hook_module (id_module, id_hook, id_shop, position) 
                                VALUES (:id_module, :id_hook, :id_shop, :position)");
                        $stmt->bindParam(':id_module', $id_module);
                        $stmt->bindParam(':id_hook', $hook_id);
                        $stmt->bindParam(':id_shop', $id_shop);
                        $stmt->bindParam(':position', $position);
                        
                        if ($stmt->execute()) {
                            echo "Module hooked to '$hook_name' for shop ID: $id_shop<br>";
                        } else {
                            echo "Failed to hook module to '$hook_name' for shop ID: $id_shop<br>";
                        }
                    }
                } catch(PDOException $e) {
                    echo "Error processing hook '$hook_name' for shop ID: $id_shop: " . $e->getMessage() . "<br>";
                }
            }
        }
    }
} catch(PDOException $e) {
    echo "Error checking shops: " . $e->getMessage() . "<br>";
}

echo "<br>Hook registration complete. Please clear your cache:<br>";
echo "1. Go to Advanced Parameters > Performance<br>";
echo "2. Click 'Clear Cache'<br>";
echo "<br>After clearing the cache, the Paystack payment method should appear on your checkout page.<br>";
echo "<br>You can delete this script now.";
?>
