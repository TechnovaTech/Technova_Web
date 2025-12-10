-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 10:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `casting_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bom_items`
--

CREATE TABLE `bom_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `material_type` enum('core','sleeve','metal','send') NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity_per_unit` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bom_items`
--

INSERT INTO `bom_items` (`id`, `product_id`, `material_type`, `material_id`, `quantity_per_unit`, `created_at`, `updated_at`) VALUES
(31, 33, 'core', 5, 2.00, '2025-06-17 06:33:38', '2025-06-17 06:33:38'),
(32, 33, 'core', 1, 1.00, '2025-06-17 06:33:38', '2025-06-17 06:33:38'),
(33, 33, 'core', 10, 2.00, '2025-06-17 06:33:38', '2025-06-17 06:33:38'),
(34, 33, 'core', 3, 3.00, '2025-06-17 06:33:38', '2025-06-17 06:33:38'),
(35, 34, 'core', 4, 2.00, '2025-06-17 06:36:33', '2025-06-17 06:36:33'),
(41, 34, 'core', 2, 2.00, '2025-07-02 05:59:40', '2025-07-02 05:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `gst_number` varchar(20) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `gst_number`, `contact_person`, `active`, `created_at`, `updated_at`) VALUES
(12, 'vivek vora', 'vivek@gmail.com', '', '608 time squre\r\n150 ft ring road rajkot', 'rajkot', 'gujrat', '360005', '5454646546', 'vivek vora', 1, '2025-06-04 10:57:14', '2025-06-24 06:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `dispatch`
--

CREATE TABLE `dispatch` (
  `id` int(11) NOT NULL,
  `gate_pass_number` varchar(50) DEFAULT NULL,
  `dispatch_number` varchar(50) NOT NULL,
  `po_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transporter` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `total_boxes` int(11) NOT NULL,
  `total_weight_kg` decimal(10,2) NOT NULL,
  `invoice_number` varchar(50) DEFAULT NULL,
  `status` enum('prepared','dispatched','delivered') DEFAULT 'prepared',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispatches`
--

CREATE TABLE `dispatches` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `dispatch_date` date NOT NULL,
  `packaging_box_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `transport_details` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `gate_pass_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dispatch_items`
--

CREATE TABLE `dispatch_items` (
  `id` int(11) NOT NULL,
  `dispatch_id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `weight_kg` decimal(10,2) NOT NULL,
  `boxes_used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fettling`
--

CREATE TABLE `fettling` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `heat_code` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `shift` varchar(20) DEFAULT NULL,
  `operator_id` int(11) NOT NULL,
  `process_type` enum('cutting','grinding','finishing') NOT NULL,
  `input_quantity` int(11) NOT NULL,
  `output_quantity` int(11) NOT NULL,
  `time_taken_hours` decimal(4,2) DEFAULT NULL,
  `status` enum('pass','fail','rework') NOT NULL,
  `remarks` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hit_boxes`
--

CREATE TABLE `hit_boxes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hit_boxes`
--

INSERT INTO `hit_boxes` (`id`, `name`, `stock`, `created_at`, `updated_at`) VALUES
(1, '1*858', 5.00, '2025-06-13 11:02:15', '2025-06-13 11:02:15'),
(2, '1*500', 10.00, '2025-06-13 11:23:21', '2025-06-13 11:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `hit_box_stock_adjustments`
--

CREATE TABLE `hit_box_stock_adjustments` (
  `id` int(11) NOT NULL,
  `hit_box_id` int(11) NOT NULL,
  `adjustment_quantity` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `knockout_batches`
--

CREATE TABLE `knockout_batches` (
  `id` int(11) NOT NULL,
  `batch_number` varchar(20) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `heat_code` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `cooling_time_minutes` int(11) NOT NULL,
  `pieces_processed` int(11) NOT NULL,
  `pieces_defective` int(11) NOT NULL,
  `defect_type` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mould_name` varchar(255) DEFAULT NULL,
  `part_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('none','core','sleeve','metal','send') NOT NULL DEFAULT 'none',
  `unit` enum('piece','kg') NOT NULL,
  `stock_qty` decimal(10,3) NOT NULL DEFAULT 0.000,
  `min_level` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_level` decimal(10,2) NOT NULL DEFAULT 0.00,
  `location` varchar(100) DEFAULT NULL,
  `cost_per_unit` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `type`, `unit`, `stock_qty`, `min_level`, `max_level`, `location`, `cost_per_unit`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Core Type A', 'core', 'kg', 10.000, 0.00, 500.00, 'Warehouse A', 50.00, 1, '2025-05-30 06:24:16', '2025-07-02 06:13:08'),
(2, 'Core Type B', 'core', 'kg', 100000.000, 0.00, 600.00, 'Warehouse A', 75.00, 1, '2025-05-30 06:24:16', '2025-07-02 05:52:56'),
(3, 'Sleeve Standard', 'sleeve', 'kg', 100000.000, 0.00, 400.00, 'Warehouse A', 100.00, 1, '2025-05-30 06:24:16', '2025-07-02 05:53:14'),
(4, 'Sleeve Large', 'sleeve', 'kg', 100000.000, 0.00, 300.00, 'Warehouse A', 150.00, 1, '2025-05-30 06:24:16', '2025-07-02 05:53:09'),
(5, 'Cast Iron', 'metal', 'kg', 100000.000, 0.00, 5000.00, 'Metal Storage', 80.00, 1, '2025-05-30 06:24:16', '2025-07-02 05:52:45'),
(6, 'Steel Alloy', 'metal', 'kg', 100000.000, 0.00, 2000.00, 'Metal Storage', 120.00, 1, '2025-05-30 06:24:16', '2025-07-02 05:53:19'),
(10, 'SEND MIN', 'send', 'kg', 100000.000, 0.00, 0.00, NULL, 5000.00, 1, '2025-06-17 06:19:07', '2025-07-02 05:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `material_stock_transactions`
--

CREATE TABLE `material_stock_transactions` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `transaction_type` enum('add','issue','adjust') NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `reference_type` enum('po','task','manual') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `melting_batches`
--

CREATE TABLE `melting_batches` (
  `id` int(11) NOT NULL,
  `batch_number` varchar(20) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `heat_code` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `metal_type` varchar(50) NOT NULL,
  `raw_material_kg` decimal(10,3) NOT NULL,
  `melted_metal_kg` decimal(10,3) NOT NULL,
  `temperature` decimal(5,1) DEFAULT NULL,
  `furnace_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moulding_batches`
--

CREATE TABLE `moulding_batches` (
  `id` int(11) NOT NULL,
  `batch_number` varchar(20) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `heat_code` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `mould_type` varchar(50) NOT NULL,
  `mould_quantity` int(11) NOT NULL,
  `sand_type` varchar(50) NOT NULL,
  `sand_used_kg` decimal(10,3) NOT NULL,
  `temperature` decimal(5,1) DEFAULT NULL,
  `mould_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `moulds`
--

CREATE TABLE `moulds` (
  `id` int(11) NOT NULL,
  `mould_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packaging_boxes`
--

CREATE TABLE `packaging_boxes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `length` decimal(10,2) NOT NULL DEFAULT 30.00,
  `width` decimal(10,2) NOT NULL DEFAULT 20.00,
  `height` decimal(10,2) NOT NULL DEFAULT 15.00,
  `size` varchar(20) NOT NULL,
  `current_stock` int(11) DEFAULT 0,
  `min_level` int(11) NOT NULL DEFAULT 0,
  `max_level` int(11) NOT NULL DEFAULT 0,
  `cost_per_unit` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packaging_boxes`
--

INSERT INTO `packaging_boxes` (`id`, `name`, `length`, `width`, `height`, `size`, `current_stock`, `min_level`, `max_level`, `cost_per_unit`, `created_at`, `updated_at`) VALUES
(1, 'Cardboard Box', 30.00, 20.00, 15.00, 'Small', 120500, 100, 1000, 25.00, '2025-05-30 06:24:16', '2025-06-02 10:43:53'),
(2, 'Cardboard Box', 45.00, 30.00, 20.00, 'Medium', 300, 50, 500, 35.00, '2025-05-30 06:24:16', '2025-06-02 08:33:32'),
(3, 'Cardboard Box', 60.00, 40.00, 30.00, 'Large', 200, 30, 300, 50.00, '2025-05-30 06:24:16', '2025-06-02 08:33:32'),
(4, 'Wooden Crate', 80.00, 60.00, 40.00, 'Medium', 50, 10, 100, 150.00, '2025-05-30 06:24:16', '2025-06-02 08:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `packaging_boxes_backup`
--

CREATE TABLE `packaging_boxes_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `box_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `min_level` int(11) NOT NULL DEFAULT 0,
  `max_level` int(11) NOT NULL DEFAULT 0,
  `cost_per_unit` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packaging_boxes_backup`
--

INSERT INTO `packaging_boxes_backup` (`id`, `box_type`, `size`, `stock_quantity`, `min_level`, `max_level`, `cost_per_unit`, `created_at`, `updated_at`) VALUES
(1, 'Cardboard Box', 'Small', 500, 100, 1000, 25.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(2, 'Cardboard Box', 'Medium', 300, 50, 500, 35.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(3, 'Cardboard Box', 'Large', 200, 30, 300, 50.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(4, 'Wooden Crate', 'Medium', 50, 10, 100, 150.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(5, 'Wooden Crate', 'Large', 30, 5, 50, 250.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(1, 'Cardboard Box', 'Small', 500, 100, 1000, 25.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(2, 'Cardboard Box', 'Medium', 300, 50, 500, 35.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(3, 'Cardboard Box', 'Large', 200, 30, 300, 50.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(4, 'Wooden Crate', 'Medium', 50, 10, 100, 150.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16'),
(5, 'Wooden Crate', 'Large', 30, 5, 50, 250.00, '2025-05-30 06:24:16', '2025-05-30 06:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `pouring_batches`
--

CREATE TABLE `pouring_batches` (
  `id` int(11) NOT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `metal_name` varchar(50) NOT NULL,
  `metal_used_kg` decimal(10,3) NOT NULL,
  `temp` decimal(10,2) DEFAULT NULL,
  `f_temp` decimal(10,2) DEFAULT NULL,
  `l_temp` decimal(10,2) DEFAULT NULL,
  `heat_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po_materials`
--

CREATE TABLE `po_materials` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `material_type` enum('core','sleeve','metal') NOT NULL,
  `quantity_required` decimal(10,2) NOT NULL,
  `is_alternative` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process_materials`
--

CREATE TABLE `process_materials` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `process_name` varchar(255) NOT NULL,
  `material_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_plan_bom_overrides`
--

CREATE TABLE `production_plan_bom_overrides` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `per_unit` decimal(10,3) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production_plan_bom_overrides`
--

INSERT INTO `production_plan_bom_overrides` (`id`, `purchase_order_id`, `product_id`, `material_id`, `per_unit`, `updated_at`) VALUES
(1, 87, 34, 4, 20.022, '2025-06-23 12:56:22'),
(9, 87, 33, 5, 5.000, '2025-06-23 12:52:16'),
(19, 87, 34, 5, 21.654, '2025-06-24 06:31:42'),
(24, 87, 34, 2, 3.000, '2025-06-24 06:15:58'),
(26, 87, 34, 1, 6.270, '2025-06-24 06:35:11'),
(27, 87, 34, 10, 6.250, '2025-06-24 08:38:18'),
(29, 88, 34, 5, 1.000, '2025-06-24 09:29:06'),
(30, 90, 34, 5, 1.096, '2025-06-24 09:52:55'),
(32, 98, 33, 5, 200.000, '2025-06-27 05:26:20'),
(33, 101, 33, 5, 2.000, '2025-06-30 05:28:47'),
(35, 102, 34, 5, 0.100, '2025-06-30 10:54:22'),
(37, 103, 34, 5, 0.333, '2025-06-30 10:04:52'),
(38, 103, 34, 10, 1.000, '2025-06-30 10:05:04'),
(39, 103, 34, 6, 0.667, '2025-06-30 10:05:11'),
(40, 103, 34, 4, 0.334, '2025-06-30 10:19:32'),
(46, 103, 34, 1, 0.667, '2025-06-30 11:02:08'),
(47, 106, 34, 5, 0.050, '2025-07-02 04:52:13'),
(48, 107, 34, 2, 2.000, '2025-07-02 06:04:37'),
(52, 107, 33, 2, 0.133, '2025-07-02 06:04:58');

-- --------------------------------------------------------

--
-- Table structure for table `production_plan_dates`
--

CREATE TABLE `production_plan_dates` (
  `purchase_order_id` int(11) NOT NULL,
  `production_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id_manual` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `unit` enum('piece','kg') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `per_piece_weight` decimal(10,2) NOT NULL DEFAULT 0.00,
  `hit_box_id` int(11) DEFAULT NULL,
  `products_per_box` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id_manual`, `name`, `description`, `unit`, `price`, `active`, `created_at`, `updated_at`, `per_piece_weight`, `hit_box_id`, `products_per_box`) VALUES
(33, 'ABC-123', 'COOKER', 'COOKER', 'piece', 200.00, 1, '2025-06-17 06:33:38', '2025-06-17 06:33:38', 2.00, 2, 10),
(34, 'AC-123', 'AC', 'AC', 'piece', 200.00, 1, '2025-06-17 06:36:33', '2025-06-17 06:36:33', 2.00, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `po_number` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `unit` enum('nos','kg') NOT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','pending_materials','in_production','completed','dispatched','cancelled') DEFAULT 'pending',
  `material_status` enum('sufficient','insufficient') DEFAULT 'sufficient',
  `delivery_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_number`, `customer_id`, `product_id`, `quantity`, `unit`, `unit_price`, `total_amount`, `status`, `material_status`, `delivery_date`, `notes`, `created_at`, `updated_at`) VALUES
(108, 'PO-123', 12, 34, 1000.00, '', NULL, NULL, 'pending', 'sufficient', '2025-07-09', NULL, '2025-07-02 06:09:48', '2025-07-02 06:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_products`
--

CREATE TABLE `purchase_order_products` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order_products`
--

INSERT INTO `purchase_order_products` (`id`, `purchase_order_id`, `product_id`, `quantity`) VALUES
(53, 108, 34, 1000.000),
(54, 108, 33, 2000.000);

-- --------------------------------------------------------

--
-- Table structure for table `rejections`
--

CREATE TABLE `rejections` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `process_stage` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason_code` varchar(50) NOT NULL,
  `reason_description` text DEFAULT NULL,
  `inspector_id` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shot_blasting`
--

CREATE TABLE `shot_blasting` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `shift` enum('morning','evening','night') NOT NULL,
  `operator_id` int(11) NOT NULL,
  `input_quantity` int(11) NOT NULL,
  `output_quantity` int(11) NOT NULL,
  `machine_used` varchar(50) DEFAULT NULL,
  `cycle_time_minutes` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shot_blasting_batches`
--

CREATE TABLE `shot_blasting_batches` (
  `id` int(11) NOT NULL,
  `batch_number` varchar(255) NOT NULL,
  `po_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `shift` varchar(50) DEFAULT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `machine_id` int(11) DEFAULT NULL,
  `pieces_processed` int(11) DEFAULT NULL,
  `media_type` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_id` int(11) DEFAULT NULL,
  `heat_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `to_do_tasks`
--

CREATE TABLE `to_do_tasks` (
  `id` int(11) NOT NULL,
  `task_type` enum('create_sleeve','create_core','other') NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `quantity_required` decimal(10,2) NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `assigned_to` varchar(50) DEFAULT NULL,
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `related_to` varchar(50) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `to_do_tasks`
--

INSERT INTO `to_do_tasks` (`id`, `task_type`, `product_id`, `po_id`, `quantity_required`, `status`, `title`, `description`, `due_date`, `assigned_to`, `priority`, `related_to`, `related_id`, `created_at`, `completed_at`, `updated_at`) VALUES
(6, 'create_sleeve', NULL, NULL, 0.00, 'pending', 'create 300 core', '300 core banavi', '2025-06-30', 'production_manager', 'medium', 'purchase_order', 0, '2025-06-03 10:59:50', NULL, '2025-06-03 10:59:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `phone`, `password_hash`, `role`, `active`, `last_login`, `created_at`, `updated_at`) VALUES
(2, 'store', 'Store Manager', '65646546546', '$2y$10$cSGCIolwo/yM680ifDbP..YwPy0TAG7cyJ7Px21/ecH/E65kDp.Wm', 'store_manager', 1, '2025-07-04 07:20:19', '2025-05-30 06:24:16', '2025-07-04 07:20:19'),
(3, 'production', 'Production Lead', '5', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'production', 1, NULL, '2025-05-30 06:24:16', '2025-06-23 08:58:26'),
(4, 'qc', 'QC Inspector', '', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qc', 1, NULL, '2025-05-30 06:24:16', '2025-06-23 08:58:41'),
(5, 'dispatch', 'Dispatch Manager', '', '$2y$10$PE4JnjURoFVn2CGqLu7Ptel465rbYlNckzPXroJoKbclqUPhotrG6', 'dispatch', 1, '2025-07-04 07:21:38', '2025-05-30 06:24:16', '2025-07-04 07:21:38'),
(6, 'admin', 'Admin', '', '$2y$10$A.HJOtZzSjgP46RFU8VIouMWQYJU5b3XGsS80eLLeIR0maGtLUMyK', 'admin', 1, '2025-07-04 08:33:31', '2025-05-30 06:29:21', '2025-07-04 08:41:00'),
(9, 'melting_op', 'Melting Operator', '', '$2y$10$ZYn1.4SWilz4QfmWgkkxI.IwBQjkPfeIrD7VtdmL3T/zYrQ5G52xq', 'melting operator', 1, '2025-06-05 05:49:25', '2025-06-04 10:46:18', '2025-06-23 08:59:11'),
(10, 'moulding_op', 'Moulding Operator', '', '$2y$10$ZYn1.4SWilz4QfmWgkkxI.IwBQjkPfeIrD7VtdmL3T/zYrQ5G52xq', 'moulding operator', 1, '2025-07-01 04:43:38', '2025-06-04 10:46:18', '2025-07-01 04:43:38'),
(11, 'knockout_op', 'Knockout Operator', '', '$2y$10$ZYn1.4SWilz4QfmWgkkxI.IwBQjkPfeIrD7VtdmL3T/zYrQ5G52xq', 'knockout operator', 1, '2025-06-05 05:53:33', '2025-06-04 10:46:18', '2025-06-23 08:59:24'),
(12, 'pouring_op', 'Pouring Operator', '', '$2y$10$ZYn1.4SWilz4QfmWgkkxI.IwBQjkPfeIrD7VtdmL3T/zYrQ5G52xq', 'pouring operator', 1, '2025-07-01 04:43:24', '2025-06-04 10:46:18', '2025-07-01 04:43:24'),
(16, 'shot_blasting', 'shot_blasting', '', '$2y$10$qACKrjh9p3yy3GFGmcJOaeetBKQDbB/hAry32GsVkApPDuhZmOG4C', 'shot_blasting', 1, '2025-06-05 05:55:30', '2025-06-05 05:51:41', '2025-06-23 08:59:36'),
(17, 'fettling', 'fettling_op', '', '$2y$10$9ioLmFapZw5NsDAptE1YBuQGRONfX23gva5nryfhu7tB6F50ozVDa', 'fettling', 1, '2025-06-05 05:56:30', '2025-06-05 05:52:27', '2025-06-23 08:59:44'),
(18, 'spidey', 'SEND MIN', '', '$2y$10$zcfX/CnA7NiumWG6iFEqYeNSAsJM6I5ku5GtSl4I/s8ug9jsMwsZ.', 'dispatch,knockout operator', 1, '2025-07-04 08:29:57', '2025-06-23 08:52:41', '2025-07-04 08:29:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bom_items`
--
ALTER TABLE `bom_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bom_product` (`product_id`),
  ADD KEY `idx_material_type` (`material_type`),
  ADD KEY `fk_bom_material` (`material_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`);

--
-- Indexes for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dispatch_po` (`po_id`),
  ADD KEY `fk_dispatch_customer` (`customer_id`);

--
-- Indexes for table `dispatches`
--
ALTER TABLE `dispatches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dispatches_po` (`purchase_order_id`),
  ADD KEY `fk_dispatches_customer` (`customer_id`),
  ADD KEY `fk_dispatches_product` (`product_id`),
  ADD KEY `fk_dispatches_packaging_box` (`packaging_box_id`);

--
-- Indexes for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dispatch_items_dispatch` (`dispatch_id`),
  ADD KEY `fk_dispatch_items_po` (`po_id`),
  ADD KEY `fk_dispatch_items_product` (`product_id`);

--
-- Indexes for table `fettling`
--
ALTER TABLE `fettling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fettling_po` (`po_id`),
  ADD KEY `fk_fettling_operator` (`operator_id`);

--
-- Indexes for table `hit_boxes`
--
ALTER TABLE `hit_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hit_box_stock_adjustments`
--
ALTER TABLE `hit_box_stock_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hit_box_adjustments` (`hit_box_id`);

--
-- Indexes for table `knockout_batches`
--
ALTER TABLE `knockout_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `operator_id` (`operator_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_stock_qty` (`stock_qty`);

--
-- Indexes for table `material_stock_transactions`
--
ALTER TABLE `material_stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_material_stock_transactions_material` (`material_id`),
  ADD KEY `fk_material_stock_transactions_operator` (`operator_id`);

--
-- Indexes for table `melting_batches`
--
ALTER TABLE `melting_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `operator_id` (`operator_id`),
  ADD KEY `fk_melting_batches_product` (`product_id`);

--
-- Indexes for table `moulding_batches`
--
ALTER TABLE `moulding_batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `operator_id` (`operator_id`),
  ADD KEY `fk_moulding_batches_product` (`product_id`);

--
-- Indexes for table `moulds`
--
ALTER TABLE `moulds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mould_name` (`mould_name`);

--
-- Indexes for table `packaging_boxes`
--
ALTER TABLE `packaging_boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_current_stock` (`current_stock`);

--
-- Indexes for table `pouring_batches`
--
ALTER TABLE `pouring_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_materials`
--
ALTER TABLE `po_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_po_materials_po` (`po_id`),
  ADD KEY `fk_po_materials_material` (`material_id`);

--
-- Indexes for table `process_materials`
--
ALTER TABLE `process_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `production_plan_bom_overrides`
--
ALTER TABLE `production_plan_bom_overrides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_order_id` (`purchase_order_id`,`product_id`,`material_id`);

--
-- Indexes for table `production_plan_dates`
--
ALTER TABLE `production_plan_dates`
  ADD PRIMARY KEY (`purchase_order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `fk_products_hit_box` (`hit_box_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_number` (`po_number`),
  ADD UNIQUE KEY `uk_po_number` (`po_number`),
  ADD KEY `fk_po_customer` (`customer_id`),
  ADD KEY `fk_po_product` (`product_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_material_status` (`material_status`);

--
-- Indexes for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rejections`
--
ALTER TABLE `rejections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rejections_po` (`po_id`),
  ADD KEY `fk_rejections_inspector` (`inspector_id`),
  ADD KEY `fk_rejections_product` (`product_id`);

--
-- Indexes for table `shot_blasting`
--
ALTER TABLE `shot_blasting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_shot_blasting_po` (`po_id`),
  ADD KEY `fk_shot_blasting_operator` (`operator_id`);

--
-- Indexes for table `shot_blasting_batches`
--
ALTER TABLE `shot_blasting_batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batch_number` (`batch_number`),
  ADD KEY `po_id` (`po_id`),
  ADD KEY `operator_id` (`operator_id`),
  ADD KEY `machine_id` (`machine_id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `to_do_tasks`
--
ALTER TABLE `to_do_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_task_product` (`product_id`),
  ADD KEY `fk_task_po` (`po_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_task_assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bom_items`
--
ALTER TABLE `bom_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dispatch`
--
ALTER TABLE `dispatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dispatches`
--
ALTER TABLE `dispatches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fettling`
--
ALTER TABLE `fettling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hit_boxes`
--
ALTER TABLE `hit_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hit_box_stock_adjustments`
--
ALTER TABLE `hit_box_stock_adjustments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `knockout_batches`
--
ALTER TABLE `knockout_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `material_stock_transactions`
--
ALTER TABLE `material_stock_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `melting_batches`
--
ALTER TABLE `melting_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=711;

--
-- AUTO_INCREMENT for table `moulding_batches`
--
ALTER TABLE `moulding_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `moulds`
--
ALTER TABLE `moulds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packaging_boxes`
--
ALTER TABLE `packaging_boxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pouring_batches`
--
ALTER TABLE `pouring_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `po_materials`
--
ALTER TABLE `po_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `process_materials`
--
ALTER TABLE `process_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `production_plan_bom_overrides`
--
ALTER TABLE `production_plan_bom_overrides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `rejections`
--
ALTER TABLE `rejections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `shot_blasting`
--
ALTER TABLE `shot_blasting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shot_blasting_batches`
--
ALTER TABLE `shot_blasting_batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `to_do_tasks`
--
ALTER TABLE `to_do_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bom_items`
--
ALTER TABLE `bom_items`
  ADD CONSTRAINT `fk_bom_material` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bom_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD CONSTRAINT `fk_dispatch_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_dispatch_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`);

--
-- Constraints for table `dispatches`
--
ALTER TABLE `dispatches`
  ADD CONSTRAINT `fk_dispatches_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_dispatches_packaging_box` FOREIGN KEY (`packaging_box_id`) REFERENCES `packaging_boxes` (`id`),
  ADD CONSTRAINT `fk_dispatches_po` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `fk_dispatches_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `dispatch_items`
--
ALTER TABLE `dispatch_items`
  ADD CONSTRAINT `fk_dispatch_items_dispatch` FOREIGN KEY (`dispatch_id`) REFERENCES `dispatch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_dispatch_items_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `fk_dispatch_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `fettling`
--
ALTER TABLE `fettling`
  ADD CONSTRAINT `fk_fettling_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_fettling_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`);

--
-- Constraints for table `hit_box_stock_adjustments`
--
ALTER TABLE `hit_box_stock_adjustments`
  ADD CONSTRAINT `fk_hit_box_adjustments` FOREIGN KEY (`hit_box_id`) REFERENCES `hit_boxes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `knockout_batches`
--
ALTER TABLE `knockout_batches`
  ADD CONSTRAINT `knockout_batches_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `knockout_batches_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `material_stock_transactions`
--
ALTER TABLE `material_stock_transactions`
  ADD CONSTRAINT `fk_material_stock_transactions_material` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `fk_material_stock_transactions_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `melting_batches`
--
ALTER TABLE `melting_batches`
  ADD CONSTRAINT `fk_melting_batches_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `melting_batches_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `melting_batches_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `moulding_batches`
--
ALTER TABLE `moulding_batches`
  ADD CONSTRAINT `fk_moulding_batches_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `moulding_batches_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `moulding_batches_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `po_materials`
--
ALTER TABLE `po_materials`
  ADD CONSTRAINT `fk_po_materials_material` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `fk_po_materials_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `process_materials`
--
ALTER TABLE `process_materials`
  ADD CONSTRAINT `process_materials_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `process_materials_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `process_materials_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `production_plan_dates`
--
ALTER TABLE `production_plan_dates`
  ADD CONSTRAINT `production_plan_dates_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_hit_box` FOREIGN KEY (`hit_box_id`) REFERENCES `hit_boxes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `fk_po_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_po_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD CONSTRAINT `purchase_order_products_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `rejections`
--
ALTER TABLE `rejections`
  ADD CONSTRAINT `fk_rejections_inspector` FOREIGN KEY (`inspector_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_rejections_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `fk_rejections_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shot_blasting`
--
ALTER TABLE `shot_blasting`
  ADD CONSTRAINT `fk_shot_blasting_operator` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_shot_blasting_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`);

--
-- Constraints for table `shot_blasting_batches`
--
ALTER TABLE `shot_blasting_batches`
  ADD CONSTRAINT `shot_blasting_batches_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `shot_blasting_batches_ibfk_2` FOREIGN KEY (`operator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shot_blasting_batches_ibfk_3` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`id`);

--
-- Constraints for table `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `todo_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `to_do_tasks`
--
ALTER TABLE `to_do_tasks`
  ADD CONSTRAINT `fk_task_po` FOREIGN KEY (`po_id`) REFERENCES `purchase_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_task_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
