<?php

echo'
<tr>
<td><input type="text" class="form-control" placeholder="Nombre de la meta..." name="nombre[]" required></td>
<td><select class="form-control" name="tipo[]" required><option disabled selected="selected" value="N">Seleccione uno</option><option value="P">Presencial</option><option value="T">Teletrabajo</option><option value="M">Mixto</option></select></td>
<td><input type="number" class="form-control" name="cantidad[]" required></td>
<td><input type="number" class="form-control" name="meta[]" required></td>      
<td><button type="button" class="btn btn-danger" id="remove" name="remove"><i class="fa fa-trash-o"></i></button></td>	
</tr>';

?>