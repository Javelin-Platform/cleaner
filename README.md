# Cleaner for Javelin
Automatically clear out log and caching files.
 
# Installation
## Manual Installation

* Download this repository
* Put the "Cleaner" directory from this repository into the "/modules" directory of your Javelin store. 
* That's it! Cleaner automatically connects to the Javelin CRON system to clean your files daily.

# Extending Cleaner

Using a Javelin `Event`, you can add additional directories that Cleaner should keep clean in your own modules. To do this, in the Events file of your module, add the following code:

```php
Events::on('cleaner_get_directories', function($directories) {
    $directories[] = 'your/directory/here';
    return $directories;
});
```

Be careful, the Cleaner module will wipe any files in the pointed directories that are older than 7 days old. It is always recommended to take a backup of your code or commit your code to Git before adding a new directory to Cleaner, just to be safe.