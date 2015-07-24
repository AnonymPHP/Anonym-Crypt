Anonym Crypt
============

Anonym Crypt Component'i dosyaları şifrelemek üzere hazırlanmıştır bir sınıftır(sınıflardır);


Sınıfın Çağırımı
----------------

```php
use Anonym\Components\Crypt\Crypter;
$crypt = new Crypter();
```

Verilerin Şifrelenmesi
--------------

```php
$encoded = $crypt->encode('test');
```

Şifrelenmiş Verilerin Çözülmesi
-----------------

```php

$decoded = $crypt->decode($encoded);

```

Şifreleme Tiplerinin Değiştirilmesi
---------------

```php

use Anonym\Components\Crypt\Base64Crypt;
$crypt->setCrypter( new Base64Crypt());

```

