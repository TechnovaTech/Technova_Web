# ERP Project Process Flow

This ERP system manages the end-to-end workflow for manufacturing, from customer onboarding to product dispatch, including user and role management. Below is a step-by-step guide to the process flow:

## 1. Add Customer
- Begin by adding a new customer to the system.
- Customers are the entities for whom products are manufactured and orders are placed.

## 2. Add Product
- After adding a customer, define the products that will be manufactured.
- Each product can have its own Bill of Materials (BOM) and production requirements.

## 3. Create Purchase Order (PO)
- Create a purchase order for a customer.
- A single purchase order can include multiple products.
- When a purchase order is created, the BOM for each product in the order is automatically generated.

## 4. Production Plan & Material Assignment
- In the production plan, you can modify the materials used for a specific product within a particular order.
- It is mandatory to specify the materials used in each process (Melting, Moulding, Pouring) for every order. If materials are not assigned, the PO will not appear in any production process.

## 5. Process Sequence
- **Melting:** The process starts with melting. Only orders with assigned materials will be available here.
- **Moulding:** Once melting is completed for an order, it becomes available in the moulding process.
- **Pouring:** After moulding is completed, the order moves to the pouring process.
- Each process must be completed in sequence for the order to progress.

## 6. Rejection Handling
- All rejections during production are recorded in the system.
- You can view and edit all rejection records as needed.

## 7. Dispatch Process
- After all production processes are completed, products are dispatched to the customer.
- The dispatch module manages and tracks outgoing shipments.

## 8. User & Role Management
- The system supports user management by the site admin.
- Admins can add users and assign one or multiple roles to each user.
- Roles determine access and permissions within the system.

## 9. Process Chart
- You can view the current stage of each order in the production workflow using the **Process Chart**.
- The process chart visually displays which stage (Melting, Moulding, Pouring, etc.) each order is currently in.
- This helps track progress and identify bottlenecks in real time.
- The process chart can be accessed from the `production chart` page in the system.

---

### Notes
- The workflow enforces strict sequencing and material assignment to ensure process integrity.
- The system is designed for flexibility in production planning and robust tracking of all manufacturing and dispatch activities. 