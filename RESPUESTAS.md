# RESPUESTAS - Examen Segundo Parcial (INF-781)

## Parte F: Pregunta Teórica

**¿Por qué `spatie/laravel-permission` cachea los permisos y qué problema de seguridad o de consistencia podría aparecer si olvidas limpiar la caché tras un cambio de permisos en producción?**

La librería utiliza caché para optimizar el rendimiento, evitando consultas costosas a la base de datos en cada verificación de permisos (`@can` o `Gate`). 

Si se realizan cambios en la base de datos sin limpiar la caché, se genera un **problema de consistencia**: el sistema seguirá aplicando permisos obsoletos o eliminados. Desde el punto de vista de seguridad, esto puede derivar en una **escalada de privilegios**, donde usuarios conserven accesos que ya no deberían tener, o en una denegación de servicio funcional, donde usuarios legítimos pierdan acceso a funciones críticas debido a la desincronización entre la base de datos y la capa de autorización. 

Para evitar esto, es fundamental ejecutar `php artisan permission:cache-reset` tras cualquier modificación en los permisos.