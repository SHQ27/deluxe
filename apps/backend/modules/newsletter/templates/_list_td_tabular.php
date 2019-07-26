<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($newsletter->getIdNewsletter(), 'newsletter_edit', $newsletter) ?>
</td>

<td class="sf_admin_text sf_admin_list_td_nombre">
  <?php echo $newsletter->getNombre(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_apellido">
  <?php echo $newsletter->getApellido(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_email">
  <?php echo link_to($newsletter->getEmail(), 'newsletter_edit', $newsletter) ?>
</td>

<td class="sf_admin_text sf_admin_list_td_sexo">
  <?php echo $newsletter->getSexoDenominacion(); ?>
</td>

<td class="sf_admin_text sf_admin_list_td_eshop">
  <?php echo ( $newsletter->getEshop() ) ? $newsletter->getEshop() : 'Deluxe Buys'; ?>  
</td>
