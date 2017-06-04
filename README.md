## NDS User Meta Manager
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description 
A simple plugin admin plugin demo to manage user meta using object oriented constructs. 
Typically these would require tinkering with the wp_usermeta table or using the add/delete_user_meta 
It also makes use of WordPress nonces wrapped in a class to be implemented in an object oriented manner.

## Installation

1. Upload `nds-user-meta-manager` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

## Usage

1. Adds an option in the Users section of the Dashboard.
2. Allows one to view/add/delete the user meta associated with a user
3. User Meta is added using the add_user_meta wordpress function and is stored in the $table_prefix_usermeta database table


## Credits 
Makes use of the Plugin Boiler Plate
https://github.com/DevinVinson/WordPress-Plugin-Boilerplate

## Screenshots
![User Menu Link](http://www.nuancedesignstudio.in/nds.in/wp-content/uploads/2017/05/nds-user-meta-manager-screen1.png "Access plugin using Users menu in Dashboard")
![Add/View/Delete User Meta](http://www.nuancedesignstudio.in/nds.in/wp-content/uploads/2017/05/nds-user-meta-manager-screen2.jpg "Use Add/View/Delete to perform basic User Meta operations") 