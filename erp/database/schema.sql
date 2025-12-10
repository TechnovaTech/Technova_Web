-- Investment Casting ERP Database Schema
-- Created for foundry management system

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: casting_erp
CREATE DATABASE IF NOT EXISTS `casting_erp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `casting_erp`;

-- --------------------------------------------------------

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin', 'store_manager', 'production', 'qc', 'dispatch') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `customers`
CREATE TABLE IF NOT EXISTS customers (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `products`
CREATE TABLE IF NOT EXISTS products (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` enum('nos', 'kg') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `materials`
CREATE TABLE IF NOT EXISTS materials (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('core', 'sleeve', 'metal', 'send') NOT NULL,
  `unit` enum('nos', 'kg') NOT NULL,
  `stock_qty` decimal(10,2) NOT NULL DEFAULT 0,
  `min_level` decimal(10,2) NOT NULL DEFAULT 0,
  `max_level` decimal(10,2) NOT NULL DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `cost_per_unit` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`),
  KEY `idx_type` (`type`),
  KEY `idx_stock_qty` (`stock_qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `bom_items`
CREATE TABLE IF NOT EXISTS bom_items (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `material_type` enum('core', 'sleeve', 'metal', 'send') NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity_per_unit` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_bom_product` (`product_id`),
  KEY `idx_material_type` (`material_type`),
  CONSTRAINT `fk_bom_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bom_material` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `purchase_orders`
CREATE TABLE IF NOT EXISTS purchase_orders (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(50) NOT NULL UNIQUE,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` enum('nos', 'kg') NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `status` enum('pending', 'pending_materials', 'in_production', 'completed', 'dispatched', 'cancelled') DEFAULT 'pending',
  `material_status` enum('sufficient', 'insufficient') DEFAULT 'sufficient',
  `delivery_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_po_number` (`po_number`),
  KEY `fk_po_customer` (`customer_id`),
  KEY `fk_po_product` (`product_id`),
  KEY `idx_status` (`status`),
  KEY `idx_material_status` (`material_status`),
  CONSTRAINT `fk_po_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `fk_po_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `material_stock_transactions`
CREATE TABLE IF NOT EXISTS material_stock_transactions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `transaction_type` enum('add', 'issue', 'adjust') NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `reference_type` enum('po', 'task', 'manual') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_material_stock_transactions_material` (`material_id`),
  CONSTRAINT `fk_material_stock_transactions_material` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `fk_material_stock_transactions_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `to_do_tasks`
CREATE TABLE IF NOT EXISTS to_do_tasks (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_type` enum('create_sleeve', 'create_core', 'other') NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `quantity_required` decimal(10,2) NOT NULL,
  `status` enum('pending', 'in_progress', 'completed') NOT NULL DEFAULT 'pending',
  `assigned_to` int(11) DEFAULT NULL,
  `priority` enum('low', 'medium', 'high') DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_task_product` (`product_id`),
  KEY `fk_task_po` (`po_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_task_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_task_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_task_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `pouring_batches`
CREATE TABLE IF NOT EXISTS pouring_batches (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch_number` varchar(50) NOT NULL,
  `po_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `shift` enum('morning', 'evening', 'night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `metal_type` varchar(50) NOT NULL,
  `metal_used_kg` decimal(10,2) NOT NULL,
  `temperature` decimal(5,1) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pouring_batches_po` (`po_id`),
  KEY `fk_pouring_batches_operator` (`operator_id`),
  CONSTRAINT `fk_pouring_batches_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_pouring_batches_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `rejections`
CREATE TABLE IF NOT EXISTS rejections (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `process_stage` enum('pouring', 'fettling', 'shot_blasting', 'final_inspection') NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason_code` varchar(50) NOT NULL,
  `reason_description` text DEFAULT NULL,
  `inspector_id` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_rejections_po` (`po_id`),
  CONSTRAINT `fk_rejections_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_rejections_inspector` FOREIGN KEY (`inspector_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `shot_blasting`
CREATE TABLE IF NOT EXISTS shot_blasting (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `shift` enum('morning', 'evening', 'night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `input_quantity` int(11) NOT NULL,
  `output_quantity` int(11) NOT NULL,
  `machine_used` varchar(50) DEFAULT NULL,
  `cycle_time_minutes` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_shot_blasting_po` (`po_id`),
  KEY `fk_shot_blasting_operator` (`operator_id`),
  CONSTRAINT `fk_shot_blasting_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_shot_blasting_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `fettling`
CREATE TABLE IF NOT EXISTS fettling (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `operator_id` int(11) NOT NULL,
  `process_type` enum('cutting', 'grinding', 'finishing') NOT NULL,
  `input_quantity` int(11) NOT NULL,
  `output_quantity` int(11) NOT NULL,
  `time_taken_hours` decimal(4,2) DEFAULT NULL,
  `status` enum('pass', 'fail', 'rework') NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_fettling_po` (`po_id`),
  KEY `fk_fettling_operator` (`operator_id`),
  CONSTRAINT `fk_fettling_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_fettling_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `packaging_boxes`
CREATE TABLE IF NOT EXISTS packaging_boxes (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `box_type` varchar(50) NOT NULL,
  `size` varchar(20) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `min_level` int(11) NOT NULL DEFAULT 0,
  `max_level` int(11) NOT NULL DEFAULT 0,
  `cost_per_unit` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_box_type` (`box_type`),
  KEY `idx_stock_quantity` (`stock_quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `dispatch`
CREATE TABLE IF NOT EXISTS dispatch (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dispatch_number` varchar(50) NOT NULL,
  `po_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transporter` varchar(100) DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `total_boxes` int(11) NOT NULL,
  `total_weight_kg` decimal(10,2) NOT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `status` enum('prepared', 'dispatched', 'delivered') DEFAULT 'prepared',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_dispatch_po` (`po_id`),
  KEY `fk_dispatch_customer` (`customer_id`),
  CONSTRAINT `fk_dispatch_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_dispatch_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `dispatch_items`
CREATE TABLE IF NOT EXISTS dispatch_items (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dispatch_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `weight_kg` decimal(10,2) NOT NULL,
  `boxes_used` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dispatch_items_dispatch` (`dispatch_id`),
  KEY `fk_dispatch_items_po` (`po_id`),
  KEY `fk_dispatch_items_product` (`product_id`),
  CONSTRAINT `fk_dispatch_items_dispatch` FOREIGN KEY (`dispatch_id`) REFERENCES `dispatch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_dispatch_items_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  CONSTRAINT `fk_dispatch_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `gate_passes`
CREATE TABLE IF NOT EXISTS gate_passes (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gate_pass_number` varchar(50) NOT NULL,
  `dispatch_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `security_approval` tinyint(1) DEFAULT 0,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_gate_pass_number` (`gate_pass_number`),
  KEY `fk_gate_passes_dispatch` (`dispatch_id`),
  KEY `fk_gate_passes_user` (`approved_by`),
  CONSTRAINT `fk_gate_passes_dispatch` FOREIGN KEY (`dispatch_id`) REFERENCES `dispatch` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_gate_passes_user` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Table structure for table `production_plan_dates`
CREATE TABLE IF NOT EXISTS production_plan_dates (
  purchase_order_id INT(11) NOT NULL PRIMARY KEY,
  production_date DATE NOT NULL,
  FOREIGN KEY (purchase_order_id) REFERENCES purchase_orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

-- Insert default admin user
INSERT INTO users (name, email, password_hash, role) 
VALUES ('Admin', 'admin@casting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample users
INSERT INTO users (name, email, password_hash, role) VALUES
('Store Manager', 'store@casting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'store_manager'),
('Production Lead', 'production@casting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'production'),
('QC Inspector', 'qc@casting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qc'),
('Dispatch Manager', 'dispatch@casting.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'dispatch');

-- Insert sample customers
INSERT INTO customers (name, email, phone, address, contact_person) VALUES
('ABC Industries', 'contact@abc-industries.com', '+91-9876543210', '123 Industrial Area, Mumbai, Maharashtra', 'John Doe'),
('XYZ Corporation', 'orders@xyzcorp.com', '+91-9876543211', '456 Business Park, Pune, Maharashtra', 'Jane Smith'),
('DEF Limited', 'procurement@deflimited.com', '+91-9876543212', '789 Manufacturing Zone, Chennai, Tamil Nadu', 'Mike Johnson'),
('GHI Enterprises', 'purchase@ghienterprises.com', '+91-9876543213', '321 Tech City, Bangalore, Karnataka', 'Sarah Williams');

-- Insert sample products
INSERT INTO products (name, description, unit, price) VALUES
('Valve Body', 'Standard valve body casting for industrial applications', 'nos', 1500.00),
('Pump Housing', 'Centrifugal pump housing with flanged connections', 'nos', 2500.00),
('Pipe Flange', 'Standard pipe flange for pipeline connections', 'kg', 200.00),
('Impeller', 'Pump impeller with balanced design', 'nos', 800.00),
('Manifold Block', 'Hydraulic manifold block with multiple ports', 'nos', 3500.00);

-- Insert sample materials
INSERT INTO materials (name, type, unit, stock_qty, min_level, max_level, location, cost_per_unit) VALUES
('Core Type A', 'core', 'nos', 150, 100, 500, 'Warehouse A', 50.00),
('Core Type B', 'core', 'nos', 200, 150, 600, 'Warehouse A', 75.00),
('Sleeve Standard', 'sleeve', 'nos', 100, 150, 400, 'Warehouse A', 100.00),
('Sleeve Large', 'sleeve', 'nos', 80, 100, 300, 'Warehouse A', 150.00),
('Cast Iron', 'metal', 'kg', 2500, 1000, 5000, 'Metal Storage', 80.00),
('Steel Alloy', 'metal', 'kg', 800, 500, 2000, 'Metal Storage', 120.00),
('Aluminum Alloy', 'metal', 'kg', 600, 300, 1500, 'Metal Storage', 200.00);

-- Insert sample BOM items
INSERT INTO bom_items (product_id, material_id, material_type, quantity_per_unit) VALUES
(1, 1, 'core', 1.0),
(1, 3, 'sleeve', 1.0),
(1, 5, 'metal', 2.5),
(2, 2, 'core', 2.0),
(2, 4, 'sleeve', 1.0),
(2, 6, 'metal', 5.0),
(3, 5, 'metal', 1.0),
(4, 1, 'core', 1.0),
(4, 7, 'metal', 1.5),
(5, 2, 'core', 3.0),
(5, 3, 'sleeve', 2.0),
(5, 6, 'metal', 8.0);

-- Insert sample packaging boxes
INSERT INTO packaging_boxes (box_type, size, stock_quantity, min_level, max_level, cost_per_unit) VALUES
('Cardboard Box', 'Small', 500, 100, 1000, 25.00),
('Cardboard Box', 'Medium', 300, 50, 500, 35.00),
('Cardboard Box', 'Large', 200, 30, 300, 50.00),
('Wooden Crate', 'Medium', 50, 10, 100, 150.00),
('Wooden Crate', 'Large', 30, 5, 50, 250.00);
