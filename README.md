trovit-api
==========

A simple PHP implementation of Trovit Affiliates API

Configuration
-------------

Before using this implementation you need to get a API token from the main Trovit Affiliates website:

https://publishers.trovit.com/

Usage
-----

In this code you'll find 2 implementations of the TrovitApi library.

The first version is the "sampleRequire.php" is the easiest one but it doesn't resolve the namespace libraries in execution time, because it just requires the main library class and use it directy.

The second version is the "sampleAutoloader.php" is not that easy to understand but is more powerfull with a ready to use namespacing system.

Before testing any of this 2 implementations you'll need to replace the following "\<YOUR-TOKEN-ID\>" in the code with your real API token key.

```
/**
 * TrovitApi Token:
 *
 * Get your Token by signing up in the following url with your details
 *
 * https://publishers.trovit.com/
 */
define('TROVIT_API_TOKEN', '<YOUR-TOKEN-ID>');
```

Thanks for using this library, I hope you enjoy it.
