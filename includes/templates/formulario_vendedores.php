<fieldset>
        <legend>Informacion General</legend>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre de el Vendedor(a)" value="<?php echo s( $vendedor->nombre ) ; ?>" >
                
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido de el Vendedor(a)" value="<?php echo s( $vendedor->apellido ) ; ?>" >
                
</fieldset>

<fieldset>
        <legend>Información Extra</legend>

        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="vendedor[telefono]" placeholder="Teléfono de el Vendedor(a)" value="<?php echo s( $vendedor->telefono ) ; ?>" >

</fieldset>
