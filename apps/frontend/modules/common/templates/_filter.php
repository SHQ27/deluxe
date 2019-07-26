<?php if ( $showFilter ): ?>    
    
    <div class="filtro <?php echo $filterId ?>">
        <form id="formFilter" action="" method="post">
        
            <div class="orderBy">
                <div class="title">
                    <span>Ordenar por</span>
                    <div class="arrow"></div>
                </div>
                <div class="options">
                    <ul>
                        <li>
                            <span class="checkbox" id="order-PRECIO_ASC">
                                <input type="checkbox" name="order" value="PRECIO_ASC" />
                            </span>
                            Precio más bajo
                        </li>
                        <li>
                            <span class="checkbox" id="order-PRECIO_DESC">
                                <input type="checkbox" name="order" value="PRECIO_DESC" />
                            </span>
                            Precio más alto
                        </li>
                        <li>
                            <span class="checkbox" id="order-MAS_VENDIDOS">
                                <input type="checkbox" name="order" value="MAS_VENDIDOS" />
                            </span>
                            Más vendidos
                        </li>
                        <li>
                            <span class="checkbox" id="order-MAS_VISITADOS">
                                <input type="checkbox" name="order" value="MAS_VISITADOS" />
                            </span>
                            Más visitados
                        </li>
                        <li>
                            <div class="buttons">
                                <input type="submit" class="formInputButton" name="apply" value="APLICAR" />
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        
            <div class="content">
                <div class="header <?php echo $headerWidthClass?>">
                    <ul>
                        <?php foreach ($collector as $name => $columnList): ?>
                        <li class="deluxeSelector" id="<?php echo $name?>">
                            <span><?php echo ucfirst($name) ?></span>
                            <div class="sprite rowDown"></div>
                        </li>
                        <?php endforeach; ?>
                        
                        <li class="rango">
                            <p>
                                <label for="amount">Rango de Precios: </label>
                                <span> 
                                    <input type="text" value="$ <?php echo (int) $rangeMin ?>" name="rango[min]" id="amountMin" /> -
                                    <input type="text" value="$ <?php echo (int) $rangeMax ?>" name="rango[max]" id="amountMax" /> 
                                </span>
                            </p>
                            <div class="slider">
                                <div id="slider-range"></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="container">
                    <?php foreach ($collector as $name => $columnList): ?>
                    <div class="lista" id="filtro-<?php echo $name ?>">
                        <?php foreach ($columnList as $col => $list): ?>
                        <div class="col">
                            <?php foreach ($list as $item): ?>
                                <?php if (is_string($item)) :?>
                                  <h2><?php echo $item ?></h2> 
                                <?php else: ?>
                                    <div class="item">

                                        <?php $id = explode(',', $item['id']); ?>
                                        <span class="checkbox" id="<?php echo $name?>-<?php echo (int) $id[0]; ?>">
                                            <input type="checkbox" name="<?php echo $name ?>" value="<?php echo $item['id']?>" />
                                        </span>
                                        
                                        <?php echo $item['value'] ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                    <div class="buttons">
                        <input type="submit" class="formInputButton" name="apply" value="APLICAR FILTROS" />
                        <input type="reset"  class="formInputButton" name="erase" value="QUITAR FILTROS" />
                    </div>
                </div>
            </div>
        
        </form>
    </div>
    
<script>
    $(document).ready( function() { filtro.setUp( <?php echo (int) $rangeMin ?> , <?php echo (int) $rangeMax ?> , <?php echo (int) $rangeSettedMin ?> , <?php echo (int) $rangeSettedMax ?> ); } );
</script>

<?php endif; ?>