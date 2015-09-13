?>
<p style="float: right; text-align: right; margin: 0;">
  $orderDate<br />
  Lab Sheet for $pid <br />
  <strong>Order Detail: $oid</strong>

</p>

<div style="float: left; margin: 0 0 1.5em 0;" >
  <img src="http://cdn.shopify.com/s/files/1/0158/6542/t/9/assets/logo.png?2270" alt="dd_sg Logo"> <br /><br />
  <!-- <strong style="font-size: 2em;">{{ shop_name }}</strong><br /><br />
  {{ shop.address }}<br/>
  {{ shop.city }} {{ shop.province_code }} {{ shop.zip | upcase }}<br/>
  {{ shop.country }}
  -->
</div>

<hr />

<h3 style="margin: 0 0 1em 0;">Item Details</h3>

<table class="table-tabular" style="margin: 0 0 1.5em 0;">
  <thead>
    <tr>
      <th>Quantity</th>
      <th>Item</th>
    </tr>
  </thead>
  <tbody>
    {% for line_item in line_items %}
      <tr>
        <td>{{ line_item.quantity }} x</td>
        <td><b>{{ line_item.title }}</b></td>
      </tr>

    {% endfor %}
  </tbody>
</table>
<!--hide transaction details and transaction gateway details
{% if transactions.size > 1 %}
  <h3 style="margin: 0 0 1em 0;">Transaction Details</h3>
  <table class="table-tabular" style="margin: 0 0 1.5em 0;">
    <thead>
      <tr>
        <th>Type</th>
        <th>Amount</th>
        <th>Kind</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>

      {% for transaction in transactions %}
        <tr>
          <td>{{ transaction.gateway | payment_method }}</td>
          <td>{{ transaction.amount | money }}</td>
          <td>{{ transaction.kind }}</td>
          <td>{{ transaction.status }}</td>
        </tr>
      {% endfor %}
    </tbody>
  </table>
{% endif %}
-->
<h3 style="margin: 0 0 1em 0;">Payment Details</h3>

<table class="table-tabular" style="margin: 0 0 1.5em 0;">
  <tr>
    <td>Subtotal price:</td>
    <td>{{ subtotal_price | money }}</td>
  </tr>
  {% for discount in discounts %}
  <tr>
    <td>Includes discount "{{ discount.code }}"</td>
    <td>{{ discount.savings | money }}</td>
  </tr>
  {% endfor %}
  <tr>
    <td>Total tax:</td>
    <td>{{ tax_price | money }}</td>
  </tr>
  {% if shipping_address %}
    <tr>
      <td>Shipping:</td>
      <td>{{ shipping_price | money }}</td>
    </tr>
  {% endif %}
  <tr>
    <td><strong>Total price:</strong></td>
    <td><strong>{{ total_price | money }}</strong></td>
  </tr>
  {% if total_paid != total_price %}
    <tr>
      <td><strong>Additional discount:</strong></td>
      <td><strong>{{ total_price | minus: total_paid | money }}</strong></td>

    </tr>

    <tr style="background-color:#F9F6F4">
        <td><strong>Total paid:</strong></td>
      <td><strong>{{ total_paid | money }}</strong></td>
    </tr>
  {% endif %}
</table>
<!-- Hide Note as well
{% if note %}
  <h3 style="margin: 0 0 1em 0;">Note</h3>
  <p>{{ note }}</p>
{% endif %}
-->
<br />
<br />
{% if shipping_address %}
  <h3 style="margin: 0 0 1em 0;">Shipping Details</h3>

  <div style="margin: 0 0 1em 0; padding: 1em; border: 1px solid black;">
    <strong>{{ shipping_address.name }}</strong><br/>
    {% if shipping_address.company %}
      {{ shipping_address.company }}<br/>
    {% endif %}
    {{ shipping_address.street }}<br/>
    {{ shipping_address.city }}
    {{ shipping_address.province_code }}
    {{ shipping_address.zip | upcase }}<br/>
    {{ shipping_address.country }}
  </div>
{% endif %}

<p>If you have any questions, please send an email to <u><!--{{ shop.email }}-->help@digbyduke.com</u></p>
