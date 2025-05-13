# Permission Matrix

This document outlines the permission structure for the application, detailing which roles have access to which permissions.

## Roles

The application has the following roles in hierarchical order:

1. **Super Admin**: Has all permissions in the system
2. **Admin**: Has administrative permissions but with some restrictions
3. **Manager**: Has permissions to manage products and categories
4. **User**: Basic user with limited permissions

## Permission Groups

Permissions are organized into the following groups:

### User Management
- `view users`: Ability to view user list and details
- `create users`: Ability to create new users
- `edit users`: Ability to edit existing users
- `delete users`: Ability to delete users
- `impersonate users`: Ability to log in as another user

### Role Management
- `view roles`: Ability to view role list and details
- `create roles`: Ability to create new roles
- `edit roles`: Ability to edit existing roles
- `delete roles`: Ability to delete roles
- `assign roles`: Ability to assign roles to users

### Permission Management
- `view permissions`: Ability to view permission list
- `create permissions`: Ability to create new permissions
- `edit permissions`: Ability to edit existing permissions
- `delete permissions`: Ability to delete permissions
- `assign permissions`: Ability to assign permissions to roles

### Product Management
- `view products`: Ability to view product list and details
- `create products`: Ability to create new products
- `edit products`: Ability to edit existing products
- `delete products`: Ability to delete products
- `publish products`: Ability to publish/unpublish products

### Category Management
- `view categories`: Ability to view category list and details
- `create categories`: Ability to create new categories
- `edit categories`: Ability to edit existing categories
- `delete categories`: Ability to delete categories

### Order Management
- `view orders`: Ability to view order list and details
- `create orders`: Ability to create new orders
- `edit orders`: Ability to edit existing orders
- `delete orders`: Ability to delete orders
- `process orders`: Ability to change order status

### System Settings
- `view settings`: Ability to view system settings
- `edit settings`: Ability to edit system settings
- `manage backups`: Ability to create and restore backups

## Role-Permission Matrix

| Permission | Super Admin | Admin | Manager | User |
|------------|-------------|-------|---------|------|
| **User Management** |
| view users | ✅ | ✅ | ✅ | ❌ |
| create users | ✅ | ✅ | ❌ | ❌ |
| edit users | ✅ | ✅ | ❌ | ❌ |
| delete users | ✅ | ❌ | ❌ | ❌ |
| impersonate users | ✅ | ❌ | ❌ | ❌ |
| **Role Management** |
| view roles | ✅ | ✅ | ❌ | ❌ |
| create roles | ✅ | ❌ | ❌ | ❌ |
| edit roles | ✅ | ❌ | ❌ | ❌ |
| delete roles | ✅ | ❌ | ❌ | ❌ |
| assign roles | ✅ | ✅ | ❌ | ❌ |
| **Permission Management** |
| view permissions | ✅ | ✅ | ❌ | ❌ |
| create permissions | ✅ | ❌ | ❌ | ❌ |
| edit permissions | ✅ | ❌ | ❌ | ❌ |
| delete permissions | ✅ | ❌ | ❌ | ❌ |
| assign permissions | ✅ | ❌ | ❌ | ❌ |
| **Product Management** |
| view products | ✅ | ✅ | ✅ | ✅ |
| create products | ✅ | ✅ | ✅ | ❌ |
| edit products | ✅ | ✅ | ✅ | ❌ |
| delete products | ✅ | ✅ | ❌ | ❌ |
| publish products | ✅ | ✅ | ✅ | ❌ |
| **Category Management** |
| view categories | ✅ | ✅ | ✅ | ✅ |
| create categories | ✅ | ✅ | ✅ | ❌ |
| edit categories | ✅ | ✅ | ✅ | ❌ |
| delete categories | ✅ | ✅ | ❌ | ❌ |
| **Order Management** |
| view orders | ✅ | ✅ | ✅ | ✅ |
| create orders | ✅ | ✅ | ✅ | ✅ |
| edit orders | ✅ | ✅ | ✅ | ❌ |
| delete orders | ✅ | ✅ | ❌ | ❌ |
| process orders | ✅ | ✅ | ✅ | ❌ |
| **System Settings** |
| view settings | ✅ | ✅ | ❌ | ❌ |
| edit settings | ✅ | ✅ | ❌ | ❌ |
| manage backups | ✅ | ❌ | ❌ | ❌ |
