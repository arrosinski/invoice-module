# Recruitment Task 🧑‍💻👩‍💻

### Invoice module with approve and reject system as a part of a bigger enterprise system. Approval module exists and you should use it. It is Backend task, no Frontend is needed.
---
Please create your own repository and make it public or invite us to check it.


<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
  - Billed company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
    - Email address
  - Products
    - Name
    - Quantity
    - Unit Price	
    - Total
  - Total price
</td>
<td>
Image just for visualization
<img src="https://templates.invoicehome.com/invoice-template-us-classic-white-750px.png" style="width: auto"; height:100%" />
</td>
</tr>
</table>

### TO DO:
Simple Invoice module which is approving or rejecting single invoice using information from existing approval module which tells if the given resource is approvable / rejectable. Only 3 endpoints are required:
```
  - Show Invoice data, like in the list above
  - Approve Invoice
  - Reject Invoice
```
* In this task you must save only invoices so don’t write repositories for every model/ entity.

* You should be able to approve or reject each invoice just once (if invoice is approved you cannot reject it and vice versa.

* You can assume that product quantity is integer and only currency is USD.

* Proper seeder is located in Invoice module and it’s named DatabaseSeeder

* In .env.example proper connection to database is established.

* Using proper DDD structure is mandatory (with elements like entity, value object, repository, mapper / proxy, DTO).
Unit tests in plus.

* Docker is in docker catalog and you need only do 
  ```
  ./start.sh
  ``` 
  to make everything work

  docker container is in docker folder. To connect with it just:
  ```
  docker compose exec workspace bash
  ``` 


## Implementation notes

- Loose coupling between modules can be achieved, assuming we require proper response, only if we implement custom exception handler
- Approval module does not have to be seperated, unless, as DTO suggests it handles multiple modules that share similar logic
- Product SHOULD NOT be used as reference in Line Item. If anything, only as link to original product. Line Item is a snapshot of a product at the time of purchase. Product can change in time - line item should not. 
- My initial instict was to use QueryBuilder, as you use Memcached in your stack, and ORM has it's own caching mechanism. There are benefits to each of the solutions, and I didn't want to tie domain entity to ORM. Definitely ORM Model should be seperated as DAO.
