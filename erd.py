from graphviz import Digraph

# Create a new Digraph object
dot = Digraph()

# Users Table
dot.node('U', 'Users\nuser_id (PK)\nusername\nemail\npassword\nprofile_photo')
# Products Table
dot.node('P', 'Products\nproduct_id (PK)\nproduct_name\nproduct_type\nproduct_quantity\nproduct_price\nproduct_size\nproduct_weight\nproduct_brand')
# Sales Table
dot.node('S', 'Sales\nsale_id (PK)\nproduct_id (FK)\nquantity_sold\nsale_date\nuser_id (FK)')

# Define the relationships between the tables
dot.edge('U', 'S', label='1:N')
dot.edge('P', 'S', label='1:N')

# Save the diagram as a file
output_path = '/mnt/data/sales_db_diagram.png'
dot.render(output_path, format='png')

output_path
