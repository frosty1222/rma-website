# Changelog for 2022 an earlier

= 3.3.1 (October 2022) =

- Tested up to WordPress 6.1.

= 3.3.0 (May 2022) =

- Fixed: Error when third party plugin passed arguments to the `get_avatar` filter. [#288](https://github.com/bonny/WordPress-Simple-History/issues/288)
- Changed: If Gravatars are disabled in WordPress ("Discussion" -> "Show Avatars" is unchecked) then Simple History respects this and also does not show any user avatars in the activity feed. A new filter has been added that can be used to override this: [`simple_history/show_avatars`](https://docs.simple-history.com/hooks#simple_history/show_avatars). [#288](https://github.com/bonny/WordPress-Simple-History/issues/288)
- Update translations. Props @kebbet. See https://docs.simple-history.com/translate for information how to update or add translations of the plugin.
- Use `constant()` function to get constant values. Makes some linting errors go away.
- Remove `languages` folder. [#287](https://github.com/bonny/WordPress-Simple-History/issues/287)

= 3.2.0 (February 2022) =

- Refactored detection of user profile updates. Order of updated user fields are now shown in the same order as they are in the edit user screen. Also the texts are updated to be more user friendly. And those "show toolbar"-messages that showed up at random times should be gone too. 🤞
- Added: Creation and deletion (revoke) of Application Passwords are now logged.
- Added: Role changes from users overview page are now logged.
- Fixed: Password reset links was always attributed to "Anonymous web user", even those that was sent from the users listing in the WordPress admin area.
- Fixed: Increase contrast ratio on some texts.
- Changed: `sh_d()` now tell you if a value is integer or numeric string or an empty string.
- Changed: The log message "Found an update to WordPress" had a dot in it. No other log message had a dot so the dot is no more.

= 3.1.1 (January 2022) =

- Fixed: Error when uploading images when using WordPress 5.7.0 or earlier.

= 3.1.0 (January 2022) =

- Fixed: Use user selected language instead of selected site language when loading languages for JavaScript libraries. ([#232](https://github.com/bonny/WordPress-Simple-History/issues/232))
- Fixed: Theme deletions are now logged again. ([#266](https://github.com/bonny/WordPress-Simple-History/issues/266))
- Fixed: Theme installs are now logged again. ([#265](https://github.com/bonny/WordPress-Simple-History/issues/265))
- Fixed: Plugin deletions are now logged again. ([#247](https://github.com/bonny/WordPress-Simple-History/issues/247), [#122](https://github.com/bonny/WordPress-Simple-History/issues/122))
- Fixed: Images and other attachments are now logged correctly when being inserted in the Block Editor.
- Fixed: Some PHP notice messages in post logger.
- Updated: JavaScript library TimeAgo updated to 1.6.7 from 1.6.3.
- Added: Log when an admin verifies that the site admin address is valid using the [Site Admin Email Verification Screen that was added in WordPress 5.3](https://make.wordpress.org/core/2019/10/17/wordpress-5-3-admin-email-verification-screen/). ([#194](https://github.com/bonny/WordPress-Simple-History/issues/194), [#225](https://github.com/bonny/WordPress-Simple-History/issues/225))
- Added: Option "All days" to date range filter dropdown. ([#196](https://github.com/bonny/WordPress-Simple-History/issues/196))
- Added: Media and other attachments now display the post they were uploaded to, if any. ([#274](https://github.com/bonny/WordPress-Simple-History/issues/274))
- Added: Add class static variables $dbtable and $dbtable_contexts that contain full db name (existing class constants DBTABLE and DBTABLE_CONTEXTS needed to be prefixed manually).
- Added: Plugin installs now save required version of PHP and WordPress.
- Changed: Plugin install source is now assumed to be "web" by default.
- Changed: Attachment updates are no longer logged from post logger since the media/attachment logger takes care of it.
- Changed: Function `sh_d()` now does not escape output when running from CLI.
- Removed: Plugin source files-listing removed from plugin installs, because the listing was incomplete, plus some more fields that no longer were able to get meaningful values (plugin rating, number or ratings, etc.).

= 3.0.0 (January 2022) =

- Fixed: Used wrong text domain for some strings in Limit Login Attempts logger.
- Fixed: Post logger now ignores changes to the `_encloseme` meta key.
- Fixed: Readme text loaded from GitHub repo is now filtered using `wp_kses()`.
- Fixed: Links in readme text loaded from GitHub repo now opens in new window/tab by default (instead of loading in the modal/thickbox iframe).
- Added: Logger messages is shown when clicking number of message strings in settings debug tab.
- Added: Num occasions in RSS feed is now wrapped in a `<p>` tag.
- Removed: "Simple Legacy Logger" is removed because it has not been used for a very long time.
- Removed: "GitHub Plugin URI" header removed from index file, so installs of Simple History from Github using Git Updater are not supported from now on.
- Removed: Box with translations notice removed from sidebar because it did not work properly when using different languages as site language and user language.
- Internal: Code formatting to better match the WordPress coding standards, code cleanup, text escaping. ([#243](https://github.com/bonny/WordPress-Simple-History/issues/243))

= 2.43.0 (October 2021) =

- Fixed: PHP notices on menu save when there are ACF fields attached ([#235](https://github.com/bonny/WordPress-Simple-History/issues/235))

- Fixed: `array_map` and `reset` cause warning in PHP 8 ([#263](https://github.com/bonny/WordPress-Simple-History/pull/263))

= 2.42.0 (April 2021) =

- Fixed: Quick diff table had to wrong sizes of the table cells. ([#246](https://github.com/bonny/WordPress-Simple-History/issues/246))

= 2.41.2 (March 2021) =

- Fixed: Error when running on PHP version 7.2 or lower.

= 2.41.1 (March 2021) =

- Fixed: Get information for correct IP Address when multiple IP addresses are shown.

= 2.41.0 (March 2021) =

- Fixed: Error when visiting settings screen on PHP 8.
  Fixes https://wordpress.org/support/topic/simple-history-fatal-error/.
  [#239](https://github.com/bonny/WordPress-Simple-History/issues/239)

= 2.40.0 (March 2021) =

- Changed: IP address is now also shown when a user successfully logs in.
  Previously the IP address was only shown for failed login attempts. Note that the IP address/es of all events are always logged and can be seen in the "context data" table that is displayed when you click the date and time of an event.
  [#233](https://github.com/bonny/WordPress-Simple-History/issues/233)

- Added: If multiple IP addresses are detected, for example when a website is running behind a proxy or similar, all IP addresses are now shown for failed and successful logins.

- Added: Filter `simple_history/row_header_output/display_ip_address` that can be used to control when the IP address/es should be visible in the main log. By default successful and failed logins are shown.

- Added: Show message when failing to get IP address due to for example ad blocker. IPInfo.io is for example blocked in the EasyList filter list that for example [Chrome extension uBlock Origin](https://chrome.google.com/webstore/detail/ublock-origin/cjpalhdlnbpafiamejdnhcphjbkeiagm) uses.

- Added: Filter `simple_history/row_header_output/template` that controls the output of the header row in the main event log.

= 2.39.0 (January 2021) =

- Added: Logging of events that a user performs via the [WP Crontrol](https://wordpress.org/plugins/wp-crontrol/) plugin (requires WP Crontrol version 1.9.0 or later). Simple History will log when cron events are added, edited, deleted, and manually ran, and when cron schedules are added and deleted. Props https://github.com/johnbillion.

= 2.38.0 (November 2020) =

- Changed: It's now possible to log things before the `after_setup_theme` hook by using the `SimpleLogger()` function. Before this change calling `SimpleLogger()` before `after_setup_theme`, or on `after_setup_theme` with a prio smaller than 10, would result in a fatal error (`Fatal error: Uncaught Error: Class 'SimpleLogger' not found`). Props https://github.com/JoryHogeveen.

- Changed: More custom post types that use the block editor ("Gutenberg") should now have their changes logged. Props https://github.com/claytoncollie.

= 2.37.2 (September 2020) =

- Fixed: Even more code that was to new for PHP 5.6 (I do have some tests, I just didn't look at them `¯\_(ツ)_/¯`.)

= 2.37.1 (September 2020) =

- Fixed: Some code was to new for PHP 5.6.

= 2.37 (September 2020) =

- Added: Enabling or disabling plugin auto-updates is now logged.
- Added: Function `sh_d()` that echoes any number of variables to the screen.
- Fixed: User logouts did show "other" instead of username of user logging out. Fixes #206, https://wordpress.org/support/topic/suspicious-logged-out-events/, https://wordpress.org/support/topic/login-logout-tracking/.
- Updated: lots of code to be formatted more according to PSR12.

= 2.36 (August 2020) =

- Fix plus and minus icons in quick diff.
- Add filter for Post Logger context. (https://github.com/bonny/WordPress-Simple-History/pull/216)
- Add link to my [GitHub sponsors page](https://github.com/sponsors/bonny/) in the sidebar.
- Misc code cleanups and smaller fixes.

= 2.35.1 (August 2020) =

Minor update to correct readme.

= 2.35 (August 2020) =

You can now [sponsor the developer of this plugin at GitHub](https://github.com/sponsors/bonny/).

**Fixed**

- Fix PHP Warning when bulk editing items in the Redirection plugin. Fixes https://github.com/bonny/WordPress-Simple-History/issues/207, https://wordpress.org/support/topic/crashes-with-redirection-plugin/. (https://github.com/bonny/WordPress-Simple-History/commit/e8be051c4d95e598275a7ba17a01f76008eb7a5b)

**Changed**

- Welcome text updated to be more correct. (https://github.com/bonny/WordPress-Simple-History/pull/211)

= 2.34 (June 2020) =

**Changed**

- Use flexbox for history page layout, so if all dropins are disabled then the content area
  spans the entire 100 % width (#199).

- Adjust style of pagination to match WordPress core pagination.

= 2.33.2 (January 2020) =

- Fix history displaying blank white space on smaller screens. Fixes https://wordpress.org/support/topic/viewing-the-log-on-a-iphone/.

= 2.33.1 (January 2020) =

- Was just an internal test version.

= 2.33 (November 2019) =

- Better compatibility with the Gutenberg Block editor.
- Correct URL redirected to after clearing log. Fixes #123.
- Fix history log on dashboard leaving lots of white space and sometimes overlapping other dashboard widgets.
  Fixes https://wordpress.org/support/topic/dashboard-block-cut-off/, https://wordpress.org/support/topic/simple-history-v2-32/, and https://wordpress.org/support/topic/new-update-not-working-10/.
- Fix join parameter order for PHP 7.4.
- Update donate link. It's now https://www.paypal.me/eskapism.
  If you like the plugin please consider donate.
  A very small amount makes me much more happy than nothing at all! ;)

= 2.32 (August 2019) =

- Fix error in Beaver Builder logger. Fixes https://wordpress.org/support/topic/conflict-with-beaver-builder-plugin-4/.
- Add filter `simple_history/admin_location` that makes is possible to move the main page from the dashboard menu to any other menu page, for example the Tools menu. Fixes https://github.com/bonny/WordPress-Simple-History/issues/140. Example usage of filter:

```php
// Move Simple History log sub page from the "Dashboard" menu to the "Tools" menu.
add_filter('simple_history/admin_location', function ($location) {
	$location = 'tools';
	return $location;
});
```

- Make it easier to extend SimplePostLogger by making `$old_post_data` protected instead of private. https://github.com/bonny/WordPress-Simple-History/pull/173.
- Try to use taxonomy name instead of taxonomy slug when showing term additions or modifications. Fixes https://github.com/bonny/WordPress-Simple-History/issues/164.
- Fix notice error when showing the log entry for a term that was deleted.
- Remove unused old function `testlog_old()`.
- Move helper functions to own file.
- Move debug code into own dropin.
- Bump required PHP version to 5.6.20 (same version that WordPress itself requires).

= 2.31 (May 2019) =

- Add support for plugin [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/).

= 2.30 (April 2019) =

- Add better Gutenberg compatibility.
- Don't log WooCommerce scheduled actions. Fixes https://wordpress.org/support/topic/cant-use-flooded-with-deleted-scheduled-action-woocommerce-webhooks/.
- Store if post password has been set, unset, or changed.
- Store if a log entry comes from the REST API. Stored in the event context as `_rest_api_request`.
- Check that logger messages exists and is array before trying to use.
- Bump required version in readme to 5.4. It's just to difficult to keep the plugin compatible with PHP less than [PHP version 5.4](http://php.net/manual/en/migration54.new-features.php).
- Updates to some translation strings.

= 2.29.2 (January 2019) =

- Fix for (the still great) plugin [Advanced Custom Fields](http://advancedcustomfields.com) 5.7.10 that removed the function `_acf_get_field_by_id` that this plugin used. Fixes https://wordpress.org/support/topic/uncaught-error-call-to-undefined-function-_acf_get_field_by_id/.

= 2.29.1 (December 2018) =

- Fix another PHP 7.3 warning. Should fix https://wordpress.org/support/topic/php-7-3-compatibility-3/.

= 2.29 (December 2018) =

- Make log welcome message translatable.
- Add two filters to make it more ease to control via filters if a logger and the combination logger + message should be logged. - `"simple_history/log/do_log/{$this->slug}"` controls if any messages for a specific logger should be logged. Simply return false to this filter to disable all logging to that logger. - `"simple_history/log/do_log/{$this->slug}/{$message_key}"` controls if a specific message for a specific logger should be logged. Simply return false to this filter to disable all logging to that logger. - Code examples for the two filters above:

  ````
  // Disable logging of any user message, i.e. any message from the logger SimpleUserLogger.
  add_filter( 'simple_history/log/do_log/SimpleUserLogger', '\_\_return_false' );

      		// Disable logging of updated posts, i.e. the message "post_updated" from the logger SimplePostLogger.
      		add_filter( 'simple_history/log/do_log/SimplePostLogger/post_updated', '__return_false' );
      		```

  ````

- add_filter('simple_history/log/do_log/SimpleUserLogger', '\_\_return_false');
- Fix notice in Redirection plugin logger due because redirection plugin can have multiple target types. Props @MaximVanhove.
- Fix warning because of missing logging messages in the categories/tags logger. Props @JeroenSormani.
- Fix warning in the next version of PHP, PHP 7.3.

= 2.28.1 (September 2018) =

- Remove a debug message that was left in the code.

= 2.28 (September 2018) =

- Always show time and sometimes date before each event, in addition to the relative date. Fixes https://wordpress.org/support/topic/feature-request-granular-settings-changes-detailed-timestamp/.
- Use WordPress own function (`wp_privacy_anonymize_ip`, available since WordPress version 4.9.6) to anonymize IP addresses, instead of our own class.
- Update timeago.js

= 2.27 (August 2018) =

- Fix notice errors when syncing an ACF field group. Fixes https://github.com/bonny/WordPress-Simple-History/issues/150.
- Fix notice error when trying to read plugin info for a plugin that no longer exists or has changed name. Fixes https://github.com/bonny/WordPress-Simple-History/issues/146.
- Always load the SimpleLogger logger. Fixes https://github.com/bonny/WordPress-Simple-History/issues/129.
- Make more texts translatable.
- Show plugin slug instead of name when translations are updated and a plugin name is not provided by the upgrader. This can happen when a plugin is using an external update service, like EDD.
- Group translation updates in the log. Useful because sometimes you update a lot of translations at the same time and the log is full of just those messages.

= 2.26.1 (July 2018) =

- Fix 5.3 compatibility.

= 2.26 (July 2018) =

- Add support for the [Jetpack plugin](https://wordpress.org/plugins/jetpack/). To begin with, activation and deactivation of Jetpack modules is logged.
- Add logging of translation updates, so now you can see when a plugin or a theme has gotten new translations. Fixes https://github.com/bonny/WordPress-Simple-History/issues/147.
- Fix notice in Advanced Custom Fields logger when saving an ACF options page.
  Fixes https://wordpress.org/support/topic/problem-with-acf-options-pages/, https://wordpress.org/support/topic/problem-with-recent-version-and-acf/, https://github.com/bonny/WordPress-Simple-History/issues/145.

= 2.25 (July 2018) =

- Add `wp_cron_current_filter` to event context when something is logged during a cron job. This can help debugging thing like posts being added or deleted by some plugin and you're trying to figure out which plugin it is.
- Fix for event details not always being shown.
- Fix for sometimes missing user name and user email in export file.

= 2.24 (July 2018) =

- Added user login and user email to CSV export file.
- Fix notice in postlogger when a post was deleted from the trash.
- Clear database in smaller steps. Fixes https://github.com/bonny/WordPress-Simple-History/issues/143.
- Fix notice in ACF logger due to misspelled variable. Fixes https://wordpress.org/support/topic/problem-with-recent-version-and-acf/.

= 2.23.1 (May 2018) =

- Remove some debug messages that was outputted to the error log. Fixes https://wordpress.org/support/topic/errors-in-php-log-since-v2-23/.
- Fix error because function `ucwords()` does not allow a second argument on PHP versions before 5.4.32. Fixes https://wordpress.org/support/topic/error-message-since-last-update/, https://wordpress.org/support/topic/errors-related-to-php-version/.
- Added new function `sh_ucwords()` that works like `ucwords()` but it also works on PHP 5.3.

= 2.23 (May 2018) =

- Add logging of privacy and GDPR related functions in WordPress. Some of the new [privacy related features in WordPress 4.9.6](https://wordpress.org/news/2018/05/wordpress-4-9-6-privacy-and-maintenance-release/) that are logged: - Privacy policy page is created or changed to a new page. - Privacy data export is requested for a user and when this request is confirmed by the user and when the data for the request is downloaded by an admin or emailed to the user. - Erase Personal Data: Request is added for user to have their personal data erased, user confirms the data removal and when the deletion of user data is done.
- Fix error when categories changes was shown in the log. Fixes https://wordpress.org/support/topic/php-notice-undefined-variable-term_object/.
- Fix error when a ACF Field Group was saved.
- Fix error when the IP address anonymization function tried to anonymize an empty IP address. Could happen when for example running wp cron locally on your server.
- Fix error when calling the REST API with an API endpoint with a closure as the callback. Fixes https://github.com/bonny/WordPress-Simple-History/issues/141.
- Rewrote logger loading method so now it's possible to name your loggers in a WordPress codings standard compatible way. Also: made a bit more code more WordPress-ish.
- The post types in the `skip_posttypes` filter are now also applied to deleted posts.
- Add function `sh_get_callable_name()` that returns a human readable name for a callback.

= 2.22.1 (May 2018) =

- Fix for some REST API Routes not working, for example when using WPCF7. Should fix https://wordpress.org/support/topic/errorexception-with-wpcf7/ and similar.

= 2.22 (May 2018) =

- IP addresses are now anonymized by default. This is mainly done because of the [General Data Protection Regulation](https://en.wikipedia.org/wiki/General_Data_Protection_Regulation) (GDPR)
  Both IPv4 and IPv6 addresses will be anonymized and the IP addresses are anonymized to their network ID.
  So for example the IPv4 address `192.168.123.124` is anonymized to `192.168.123.0` and
  the IPv6 address `2a03:2880:2110:df07:face:b00c::1` is anonymized by default to `2610:28:3090:3001::`.

- Added filter `simple_history/privacy/anonymize_ip_address` than can be used to disable ip address anonymization.

- Added function `sh_error_log()` to easily log variables to the error log. Probably only of interest to developers.

- Fixed logging for [plugin Redirection](https://wordpress.org/plugins/redirection/). The logging of URL redirects and so on stopped working some while back because the Redirection plugin started using the WP REST API. But now it's working again!

= 2.21.1 (May 2018) =

- Make sure support for Advanced Custom Fields is activated for all users – and not only for the developer of the plugin ;)

= 2.21 (May 2018) =

- Added support for Advanced Custom Fields (ACF): when a ACF Field or ACF Field Group is created or modified or deleted you will now get more details in the activity feed.
- Changes to taxonomies/categories/tags now include a link to the modified term and to the category that the term belongs to.
- The post types in the `skip_posttypes` filter are now also applied to trashed and untrashed posts (not only post edits, as before).
- Don't log Jetpack sitemap updates. (Don't log updates to posttypes `jp_sitemap`, `jp_sitemap_master` and `jp_img_sitemap`, i.e. the post types used by Jetpack's Sitemap function.) Should fix https://wordpress.org/support/topic/jetpack-sitemap-logging/.
- Don't log the taxonomies `post_translations` or `term_translations`, that are used by Polylang to store translation mappings. That contained md5-hashed strings and was not of any benefit (a separate logger for Polylang will come soon anyway).
- Fix notice in theme logger because did not check if `$_POST['sidebar']` was set. Fixes https://github.com/bonny/WordPress-Simple-History/issues/136.
- Fix thumbnail title missing notice in post logger.
- Fix PHP warning when a plugin was checked by WordPress for an update, but your WordPress install did not have the plugin folder for that plugin.
- Fix unexpected single-quotations included in file name in Internet Explorer 11 (and possibly other versions) when exporting CSV/JSON file.
- Fix filter/search log by specific users not working. Fixes https://wordpress.org/support/topic/show-activity-from-other-authors-only/.
- Fix a notice in SimpleOptionsLogger.
- Better CSS styling on dashboard.
- Add filter `simple_history/post_logger/post_updated/context` that can be used to modify the context added by SimplePostLogger.
- Add filter `simple_history/post_logger/post_updated/ok_to_log` that can be used to skip logging a post update.
- Add filter `simple_history/categories_logger/skip_taxonomies` that can be used to modify what taxonomies to skip when logging updates to taxonomy terms.

= 2.20 (November 2017) =

- Add logging of post thumbnails.
- Use medium size of image attachments when showing uploaded files in the log. Previously a custom size was used, a size that most sites did not have and instead the full size image would be outputted = waste of bandwidth.
- Make image previews smaller because many uploaded images could make the log a bit to long and not so quick to overview.
- Update Select2 to latest version. Fixes https://wordpress.org/support/topic/select2-js-is-outdated/.
- Show a message if user is running to old WordPress version, and don't continue running the code of this plugin.
  Should fix stuff like https://wordpress.org/support/topic/simple-history-i-cannot-login/.
- Fix an error with PHP 7.1.

= 2.19 (November 2017) =

- Add filter `simple_history/user_can_clear_log`. Return `false` from this filter to disable the "Clear blog" button.
- Remove static keyword from some methods in SimpleLogger, so now calls like `SimpleLogger()->critical('Doh!');` works.
- Don't show link to WordPress updates if user is not allowed to view the updates page.
- Fix notice error in SimpleOptionsLogger.
- Fix for fatal errors when using the lost password form in [Membership 2](https://wordpress.org/plugins/membership/). Fixes https://wordpress.org/support/topic/conflict-with-simple-history-plugin-and-php-7/.
- Code (a little bit) better formatted according to [WordPress coding standard](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards).

= 2.18 (August 2017) =

- Set from_term_description correctly, fixes https://github.com/bonny/WordPress-Simple-History/issues/127.
- Add filter `simple_history/post_logger/skip_posttypes`.
- Don't log post type `jetpack_migation` because for some users that post type filled the log. Fixes https://wordpress.org/support/topic/updated-jetpack_migration-sidebars_widgets/.

= 2.17 (June 2017) =

- Fix search date range inputs not showing correctly.
- Change the message for when a plugin is deactivated due to an error. Now the plugin slug is included, so you know exactly what plugin has been deactivated. Also the reason for the deactivation is included (one of "Invalid plugin path", "Plugin file does not exist", or "The plugin does not have a valid header.").
- Added more filters to log message. Now filter `simple_history_log_debug` exists, together with filters for all other 7 log levels. So you can use `simple_history_log_{loglevel}` where {loglevel} is any of emergency, alert, critical, error, warning, notice, info or debug.
- Add support for logging the changing of "locale" on a user profile, something that was added in WordPress 4.7.
- Add sidebar box with link to the settings page.
- Don't log when old posts are deleted from the trash during cron job wp_scheduled_delete.
- HHVM is not used for any tests any longer because PHP 7 and Travis not supporting it or something. I dunno. Something like that.
- When "development debug mode" is activated also log current filters.
- Show an admin warning if a logger slug is longer than 30 chars.
- Fix fatal error when calling log() method with null as context argument.

= 2.16 (May 2017) =

- Added [WP-CLI](https://wp-cli.org) command for Simple History. Now you can write `wp simple-history list` to see the latest entries from the history log. For now `list` is the only available command. Let me know if you need more commands!
- Added support for logging edits to theme files and plugin files. When a file is edited you will also get a quick diff on the changes,
  so you can see what CSS styles a client changed or what PHP changes they made in a plugin file.
- Removed the edit file logger from the plugin logger, because it did not always work (checked wrong wp path). Instead the new Theme and plugins logger mentioned above will take care of this.

= 2.15 (May 2017) =

- Use thumbnail version of PDF preview instead of full size image.
- Remove Google Maps image when clicking IP address of failed login and similar, because Google Maps must be used with API key.
  Hostname, Network, City, Region and Country is still shown.
- Fix notice in available updates logger.
- Fix notice in redirection logger.

= 2.14.1 (April 2017) =

- Fix for users running on older PHP versions.

= 2.14 (April 2017) =

- Added support for plugin [Duplicate Post](https://wordpress.org/plugins/duplicate-post/).
  Now when a user clones a post or page you will se this in the history log, with links to both the original post and the new copy.
- Removed log level info from title in RSS feed
- Make date dropdown less "jumpy" when loading page (due to select element switching to Select2)
- Only add filters for plugin Limit Login Attempts if plugin is active. This fixes problem with Limit Login Attempts Reloaded and possibly other forks of the plugin.
- Debug page now displays installed plugins.

= 2.13 (November 2016) =

- Added filter `simple_history_log` that is a simplified way to add message to the log, without the need to check for the existence of Simple History or its SimpleLogger function. Use it like this: `apply_filters("simple_history_log", "This is a logged message");` See the [examples file](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php) for more examples.
- IP info now displays a popup with map + geolocation info for users using HTTPS again. Thanks to the great https://twitter.com/ipinfoio for letting all users use their service :)
- Fix notice warning for missing `$data_parent_row`

= 2.12 (September 2016) =

- You can show a different number of log items in the log on the dashboard and on the dedicated history page. By default the dashboard will show 5 items and the page will show 30.
- On multisites the user search filter now only search users in the current site.
- The statistics chart using Chart.js now uses the namespace window.Simple_History_Chart instead of window.Chart, decreasing the risk that two versions of the Chart.js library overwriting each others. Fixes https://wordpress.org/support/topic/comet-cache-breaks-simple-history/. (Note to future me: this was fixed by renaming the `window.chart` variable to `window.chart.Simple_history_chart` in the line `window.Chart = module.exports = Chart;`)
- If spam comments are logged they are now included in the log. Change made to make sql query shorter and easier. Should not actually show any spam comments anyway because we don't log them since version 2.5.5 anyway. If you want to revert this behavior for some reason you can use the filter `simple_history/comments_logger/include_spam`.

= 2.11 (September 2016) =

- Added support for plugin [Redirection](https://wordpress.org/plugins/redirection/).
  Redirects and groups that are created, changed, enabled and disabled will be logged. Also when the plugin global settings are changed that will be logged.
- Fix possible notice error from User logger.
- "View changelog" link now works on multisite.

= 2.10 (September 2016) =

- Available updates to plugins, themes, and WordPress itself is now logged.
  Pretty great if you subscribe to the RSS feed to get the changes on a site. No need to manually check the updates-page to see if there are any updates.
- Changed to logic used to determine if a post edit should be logged or not. Version 2.9 used a version that started to log a bit to much for some plugins. This should fix the problems with the Nextgen Gallery, All-In-One Events Calendar, and Membership 2 plugins. If you still have problems with a plugin that is causing to many events to be logged, please let me know!

= 2.9.1 (August 2016) =

- Fixed an issue where the logged time was off by some hours, due to timezone being manually set elsewhere.
  Should fix https://wordpress.org/support/topic/logged-time-off-by-2-hours and https://wordpress.org/support/topic/different-time-between-dashboard-and-logger.
- Fixed Nextgen Gallery and Nextgen Gallery Plus logging lots and lots of event when viewing posts with galleries. The posts was actually updated, so this plugin did nothing wrong. But it was indeed a bit annoying and most likely something you didn't want in your log. Fixes https://wordpress.org/support/topic/non-stop-logging-nextgen-gallery-items.

= 2.9 (August 2016) =

- Added custom date ranges to the dates filter. Just select "Custom date range..." in the dates dropdown and you can choose to see the log between any two exact dates.
- The values in the statistics graph can now be clicked and when clicked the log is filtered to only show logged events from that day. Very convenient if you have a larger number of events logged for one day and quickly want to find out what exactly was logged that day.
- Dates filter no longer accepts multi values. It was indeed a bit confusing that you could select both "Last 7 days" and "Last 3 days".
- Fix for empty previous plugin version (the `{plugin_prev_version}` placeholder) when updating plugins.
- Post and pages updates done in the WordPress apps for Ios and Android should be logged again.

= 2.8 (August 2016) =

- Theme installs are now logged
- ...and so are theme updates
- ...and theme deletions. Awesome!
- Support for plugin [Limit Login Attempts](https://wordpress.org/plugins/limit-login-attempts/).
  Failed login attempts, lockouts and configuration changes will be logged.
- Correct message is now used when a plugin update fails, i.e. the message for key `plugin_update_failed`.
- The original untranslated strings for plugin name and so on are stored when storing info for plugin installs and updates and similar.
- Default number of events to show is now 10 instead of 5.

= 2.7.5 (August 2016) =

- User logins using e-mail are now logged correctly. Previously the user would be logged in successfully but the log said that they failed.
- Security fix: only users with [`list_users`](https://codex.wordpress.org/Roles_and_Capabilities#list_users) capability can view the users filter and use the autocomplete api for users.
  Previously the autocomplete function could be used by all logged in users.
- Add labels to search filters. (I do really hate label-less forms so it's kinda very strange that this was not in place before.)
- Misc other internal fixes

= 2.7.4 (July 2016) =

- Log a warning message if a plugin gets disabled automatically by WordPress because of any of these errors: "Plugin file does not exist.", "Invalid plugin path.", "The plugin does not have a valid header."
- Fix warning error if `on_wp_login()` was called without second argument.
- Fix options diff not being shown correctly.
- Fix notice if no message key did exist for a log message.

= 2.7.3 (June 2016) =

- Removed the usage of the mb\_\* functions and mbstring is no longer a requirement.
- Added a new debug tab to the settings page. On the debug page you can see stuff like how large your database is and how many rows that are stored in the database. Also, a list of all loggers are listed there together with some useful (for developers anyway) information.

= 2.7.2 (June 2016) =

- Fixed message about mbstring required not being echo'ed.
- Fixed notice errors for users not allowed to view the log.

= 2.7.1 (June 2016) =

- Added: Add shortcut to history in Admin bar for current site and in Network Admin Bar for each site where plugin is installed. Can be disabled using filters `simple_history/add_admin_bar_menu_item` and `simple_history/add_admin_bar_network_menu_item`.
- Added: Add check that [´mbstring´](http://php.net/manual/en/book.mbstring.php) is enabled and show a warning if it's not.
- Changed: Changes to "Front Page Displays" in "Reading Settings" now show the name of the old and new page (before only id was logged).
- Changed: Changes to "Default Post Category" and "Default Mail Category" in "Writing Settings" now show the name of the old and new category (before only id was logged).
- Fixed: When changing "Front Page Displays" in "Reading Settings" the option "rewrite_rules" also got logged.
- Fixed: Changes in Permalink Settings were not logged correctly.
- Fixed: Actions done with [WP-CLI](https://wp-cli.org/) was not correctly attributed. Now the log should say "WP-CLI" instead of "Other" for actions done in WP CLI.

= 2.7 (May 2016) =

- Added: When a user is created or edited the log now shows what fields have changed and from what old value to what new value. A much requested feature!
- Fixed: If you edited your own profile the log would say that you edited "their profile". Now it says that you edited "your profile" instead.
- Changed: Post diffs could get very tall. Now they are max approx 8 rows by default, but if you hover the diff (or give it focus with your keyboard) you get a scrollbar and can scroll the contents. Fixes https://wordpress.org/support/topic/dashboard-max-length-of-content and https://wordpress.org/support/topic/feature-request-make-content-diff-report-expandable-and-closed-by-default.
- Fixed: Maybe fix a notice warning if a transient was missing a name or value.

= 2.6 (May 2016) =

- Added: A nice little graph in the sidebar that displays the number of logged events per day the last 28 days. Graph is powered by [Chart.js](http://www.chartjs.org/).
- Added: Function `get_num_events_last_n_days()`
- Added: Function `get_num_events_per_day_last_n_days()`
- Changed: Switched to transients from cache at some places, because more people will benefit from transients instead of cache (that requires object cache to be installed).
- Changed: New constant `SETTINGS_GENERAL_OPTION_GROUP`. Fixes https://wordpress.org/support/topic/constant-for-settings-option-group-name-option_group.
- Fixed: Long log messages with no spaces would get cut of. Now all the message is shown, but with one or several line breaks. Fixes https://github.com/bonny/WordPress-Simple-History/pull/112.
- Fixed: Some small CSS modification to make the page less "jumpy" while loading (for example setting a default height to the select2 input box).

= 2.5.5 (April 2016) =

- Changed: The logger for Enable Media Replace required the capability `edit_files` to view the logged events, but since this also made it impossible to view events if the constant `DISALLOW_FILE_EDIT` was true. Now Enable Media Replace requires the capability `upload_files` instead. Makes more sense. Fixes https://wordpress.org/support/topic/simple-history-and-disallow_file_edit.
- Changed: No longer log spam trackbacks or comments. Before this version these where logged, but not shown.
- Fixed: Translations was not loaded for Select2. Fixes https://wordpress.org/support/topic/found-a-string-thats-not-translatable-v-254.
- Fixed: LogQuery `date_to`-argument was using `date_from`.
- Changed: The changelog for 2015 and earlier are now moved to [CHANGELOG.md](https://github.com/bonny/WordPress-Simple-History/blob/master/CHANGELOG.md).

= 2.5.4 (March 2016) =

- Added: Support for new key in info array from logger: "name_via". Set this value in a logger and the string will be shown next to the date of the logged event. Useful when logging actions from third party plugins, or any kind of other logging that is not from WordPress core.
- Added: Method `getInfoValueByKey` added to the SimpleLogger class, for easier retrieval of values from the info array of a logger.
- Fixed: Themes could no be deleted. Fixes https://github.com/bonny/WordPress-Simple-History/issues/98 and https://wordpress.org/support/topic/deleting-theme-1.
- Fixed: Notice error when generating permalink for event.
- Fixed: Removed a `console.log()`.
- Changed: Check that array key is integer or string. Hopefully fixes https://wordpress.org/support/topic/error-in-wp-adminerror_log.

= 2.5.3 (February 2016) =

- Fixed: Old entries was not correctly removed. Fixes https://github.com/bonny/WordPress-Simple-History/issues/108.

= 2.5.2 (February 2016) =

- Added: The GUI log now updates the relative "fuzzy" timestamps in real time. This means that if you keep the log opened, the relative date for each event, for example "2 minutes ago" or "2 hours ago", will always be up to date (hah!). Keep the log opened for 5 minutes and you will see that the event that previously said "2 minutes ago" now says "7 minutes ago". Fixes https://github.com/bonny/WordPress-Simple-History/issues/88 and is implemented using the great [timeago jquery plugin](http://timeago.yarp.com/).
- Added: Filter `simple_history/user_logger/plain_text_output_use_you`. Works the same way as the `simple_history/header_initiator_use_you` filter, but for the rich text part when a user has edited their profile.
- Fixed: Logger slugs that contained for example backslashes (becuase they where namespaced) would not show up in the log. Now logger slugs are escaped. Fixes https://github.com/bonny/WordPress-Simple-History/issues/103.
- Changed: Actions and things that only is needed in admin area are now only called if `is_admin()`. Fixes https://github.com/bonny/WordPress-Simple-History/issues/105.

= 2.5.1 (February 2016) =

- Fixed: No longer assume that the ajaxurl don't already contains query params. Should fix problems with third party plugins like [WPML](https://wpml.org/).
- Fixed: Notice if context key did not exist. Should fix https://github.com/bonny/WordPress-Simple-History/issues/100.
- Fixed: Name and title on dashboard and settings page were not translateable. Fixes https://wordpress.org/support/topic/dashboard-max-length-of-content.
- Fixed: Typo when user resets password.
- Added: Filter `simple_history/row_header_date_output`.
- Added: Filter `simple_history/log/inserted`.
- Added: Filter `simple_history/row_header_date_output`.

= 2.5 (December 2015) =

- Added: Category edits are now logged, so now you can see terms, categories and taxonomies that are added, changed, and deleted. Fixes for example https://wordpress.org/support/topic/view-changes-to-categories and https://twitter.com/hmarafi/status/655994402037362688.
- Fixed: The media logger now shows the width and height of uploaded images again.
- Fixed: IP Lookup using ipinfo.io would fail if your site was using HTTPS (pro account on ipinfo.io required for that), so now falls back to opening a link to ipinfo.io in a new tab instead.
- Fixed: If there was a server error while loading the log, the error would be shown, to help you debug any errors. The error would however not go away if you successfully loaded the log again. Now it does.
- Changed: The search/filter now falls back to showing events for the last 14 days, if 30 days would return over 1000 pages of events. This change is to try to make the log fail to load in less scenarios. If a site got a bit spike if brute force attacks (yes, it's always those attacks!) then there could be a big jump in the number of events and pages between 14 days and 30 days.
- Changed: Failed login attempts now use shorter messages and shorter variable names. Not really the fault of this plugin, but sites can get a huge amount of failed login attempts logged. Sites with almost 2 million logged rows just in the last 60 days for example. And that will cause the database tables with the history to grow to several hundreds of megabyte. So to make those tables a bit smaller the plugin now uses shorter messages for failed login attempts, shorter variable names, and it stores less data. If you want to stop hackers from attacking your site (resulting in big history logs) you should install a plugin like [Jetpack and its BruteProtect module](https://jetpack.me/support/security-features/).
- Updated: Added date filter to show just events from just one day. Useful for sites that get hammered by brute force login attempts. On one site where I had 166434 login attempts the last 7 days this helped to make the log actually load :/.
- Updated: New French translation

= 2.4 (November 2015) =

- Added: Now logs when a user changes their password using the "reset password" link.
- Added: Now logs when a user uses the password reset form.
- Added: New method `register_dropin` that can be used to add dropins.
- Added: New action `simple_history/add_custom_dropin`.
- Added: Example on how to add an external dropin: [example-dropin.php](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/example-dropin.php).
- Added: "Last day" added to filter, because a brute force attack can add so many logs that it's not possible to fetch a whole week.
- Changed: Filter `simple_history/log/do_log` now pass 5 arguments instead of 3. Before this update in was not possible for multiple add_action()-calls to use this filter, because you would not now if any other code had canceled it and so on. If you have been using this filter you need to modify your code.
- Changed: When hovering the time of an event in the log, the date of the event displays in both local time and GMT time. Hopefully makes it easier for admins in different timezones that work together on a site to understand when each event happened. Fixes https://github.com/bonny/WordPress-Simple-History/issues/84.
- Fixed: Line height was a bit tight on the dashboard. Also: the margin was a tad to small for the first logged event on the dashboard.
- Fixed: Username was not added correctly to failed login attempts when using plugin Captcha on Login + it would still show that a user logged out sometimes when a bot/script brute force attacked a site by only sending login and password and not the captcha field.

= 2.3.1 (October 2015) =

- Fixed: Hopefully fixed the wrong relative time, as reported here: https://wordpress.org/support/topic/wrong-reporting-time.
- Changed: The RSS-feed with updates is now disabled by default for new installs. It is password protected, but some users felt that is should be optional to activate it. And now it is! Thanks to https://github.com/guillaumemolter for adding this feature.
- Fixed: Failed login entries when using plugin [Captcha on Login](https://wordpress.org/plugins/captcha-on-login/) was reported as "Logged out" when they really meant "Failed to log in". Please note that this was nothing that Simple History did wrong, it was rather Captcha on Login that manually called `wp_logout()` each time a user failed to login. Should fix all those mystery "Logged out"-entried some of you users had.
- Added: Filter `simple_history/log/do_log` that can be used to shortcut the log()-method.
- Updated: German translation updated.

= 2.3 (October 2015) =

- Added: The title of the browser tab with Simple History open will now show the number of new and unread events available. Nice feature to have if you keep a tab with the Simple History log open but in the background: now you can see directly in the title if new events are available. Such small change. Very much nice.
- Added: If the AJAX call to fetch the log failed, a message now appears telling the user that something went wrong. Also, the output from the server is displayed so they can get a hint of what's going wrong. Hopefully this will reduce the number of support requests that is caused by other plugins.
- Fixed: Edited posts/pages/custom post types does not get a linked title unless the user viewing the log has edit rights.
- Fixed: Another try to fix the notice error here: https://wordpress.org/support/topic/simplehistoryphp-creates-debug-entries.
- Updated: Danish translation updated.
- Updated: POT file updated.

= 2.2.4 (September 2015) =

- Added: Basic support for plugin [Ultimate Member](https://wordpress.org/plugins/ultimate-member/), so users logging in using the plugin will now be logged in Simple History. Fixes https://wordpress.org/support/topic/compatibility-with-ultimate-member.
- Added: Filter `simple_history/logger/interpolate/context` that can be used to modify the variables sent to the message template.
- Changed: Remove "type" key from context detail table, because it's an old an unused column.
- Changed: During a first install the plugin now creates a few less columns than before (some columns where left from version 1 of the plugin).
- Changed: Don't show the "translate this plugin" metabox for any english talking locale.
- Changed: Don't show the GitHub metabox.
- Fixed: If the plugin is deleted (but why?!) then the context table is also removed now.
- Behind the scenes: More unit tests! Hopefully more nasty things will get caught before releasing new versions of the plugin.

= 2.2.3 (September 2015) =

- Fixed: On new installs the database tables was not created correctly and new events could not be logged.

= 2.2.2 (September 2015) =

- Fixed: Logging stopped working for languages other then English. Sorry about that!
- Fixed: When running unit tests for a site where Simple History is a must use plugin it sometimes tried to create tables and add columns more then once. Now uses `if not exists` and similar to only try to create the tables if they not already exists.

= 2.2.1 (September 2015) =

- Fixed: Missed to log users switching back on using the User Switching plugin. Fixes https://github.com/bonny/WordPress-Simple-History/issues/89.

= 2.2 (September 2015) =

- Added: Support for plugin [User Switching](https://wordpress.org/plugins/user-switching/). The event log will show when a user switched to another user, when they switched back, or when they switched off.
- Added: Support for plugin [Enable Media Replace](https://wordpress.org/plugins/enable-media-replace/). Whenever a user replaces an attachment with a new, you will now know about it and also see the name of both the old and the new attachment. Awesome!
- Fixed: Mouse over (:hover state) on buttons no longer use blue background. Now works much better with admin themes other than the standard one. Fixes https://wordpress.org/support/topic/pagination-button-design.

= 2.1.7 (September 2015) =

- Fixed: Date and time in the log was using GMT time rather than local time. Could be confusing. Even very confusing if living in a time zone far far away from the GMT zone.

= 2.1.6 (August 2015) =

- Updated: Danish translation updated. Thanks translator!
- Fixed: Icon on settings page was a bit unaligned on WordPress not running the latest beta version (hrm, which I guess most of you were..)
- Fixed: Possible php notice. Should fix https://wordpress.org/support/topic/simplehistoryphp-creates-debug-entries.
- Changed: Logged messages are now trimmed by default (spaces and new lines will be removed from messages).
- Updated: When installing and activating the plugin it will now add the same "plugin installed" and "plugin activated" message that other plugins get when they are installed. These events where not logged before because the plugin was not installed and could therefor not log its own installation. Solution was to log it manually. Works. Looks good. But perhaps a bit of cheating.
- Added: A (hopefully) better welcome message when activating the plugin for the first time. Hopefully the new message makes new users understand a bit better why the log may be empty at first.

= 2.1.5 (August 2015) =

- Fixed: It was not possible to modify the filters `simple_history/view_settings_capability` and `simple_history/view_history_capability` from the `functions.php`-file in a theme (filters where applied too early - they did however work from within a plugin!)
- Changed: Use `h1` instead of `h2` on admin screens. Reason for this the changes in 4.3: https://make.wordpress.org/core/2015/07/31/headings-in-admin-screens-change-in-wordpress-4-3/.
- Removed: the constant `VERSION` is now removed. Use constant `SIMPLE_HISTORY_VERSION` instead of you need to check the current version of Simple History.

= 2.1.4 (July 2015) =

- Fixed: WordPress core updates got the wrong previous version.
- Updated: Updated German translations.
- Added: GHU header added to plugin header, to support [GitHub Updater plugin](https://github.com/afragen/github-updater).

= 2.1.3 (July 2015) =

- Fixed: Ajax error when loading a log that contained uploaded images.
- Fixed: Removed some debug log messages.

= 2.1.2 (July 2015) =

- Changed: By default the log now shows events from the last week, last two weeks or last 30 days, all depending on how many events you have in your log. The previous behavior was to not apply any filtering what so ever during the first load. Anyway: this change makes it possible to load the log very quickly even for very large logs. A large amount of users + keeping the log forever = millions of rows of data. Previously this could stall the log or make it load almost forever. Now = almost always very fast. I have tried it with over 5.000 users and a million row and yes - zing! - much faster. Fixes https://wordpress.org/support/topic/load-with-pagination-mysql.
- Added: Finnish translation. Thanks a lot to the translator!
- Updated: Swedish translation updated
- Added: Cache is used on a few more places.
- Added: Plugin now works as a ["must-use-plugin"](https://codex.wordpress.org/Must_Use_Plugins). Props [jacquesletesson](https://github.com/jacquesletesson).
- Added: Filter `SimpleHistoryFilterDropin/show_more_filters_on_load` that is used to control if the search options should be expanded by default when the history page is loaded. Default is false, to have a less cluttered GUI.
- Added: Filter `SimpleHistoryFilterDropin/filter_default_user_ids` that is used to search/filter specific user ids by default (no need to search and select users). Should fix https://wordpress.org/support/topic/how-to-pass-array-of-user-ids-to-history-query.
- Added: Filter `SimpleHistoryFilterDropin/filter_default_loglevel` that is used to search/filter for log levels by default.
- Fixed: if trying to log an array or an object the logger now automagically runs `json_encode()` on the value to make it a string. Previously is just tried to run `$wpdb->insert()` with the array and that gave errors. Should fix https://wordpress.org/support/topic/mysql_real_escape_string.
- Fixed: The function that checks for new rows each second (or actually each tenth second to spare resources) was called an extra time each time the submit button for the filter was clicked. Kinda stupid. Kinda fixed now.
- Fixed: The export feature that was added in version 2.1 was actually not enabled for all users. Now it is!
- Fixed: Image attachments that is deleted from file system no longer result in "broken image" in the log. (Rare case, I know, but it does happen for me that local dev server and remote prod server gets out of "sync" when it comes to attachments.)

= 2.1.1 (May 2015) =

- Removed: filter `simple_history/dropins_dir` removed.
- Changed: Dropins are not loaded from a `glob()` call anymore (just like plugins in the prev release)
- Updated: Brazilian Portuguese translation updated.
- Fixed: POT file updated for translators.
- Fixed: Better sanitization of API arguments.

= 2.1 (May 2015) =

- Added: Export! Now it's possible to export the events log to a JSON or CSV formatted file. It's your data so you should be able to export it any time you want or need. And now you can do that. You will find the export function in the Simple History settings page (Settings -> Simple History).
- Added: Filter `simple_history/add_custom_logger` and function `register_logger` that together are used to load external custom loggers. See [example-logger.php](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/example-logger.php) for usage example.
- Added: Filter `simple_history/header_initiator_use_you`.
- Fixed: Fixed an undefined variable in get_avatar(). Fixes https://github.com/bonny/WordPress-Simple-History/issues/74.
- Fixed: When using [HyperDB](https://wordpress.org/support/plugin/hyperdb) only one event was returned. Fixed by using [adding `NO_SELECT_FOUND_ROWS` to the query](https://plugins.trac.wordpress.org/browser/hyperdb/trunk/db.php?#L49). Should fix problems for users using HyperDB and also users using for example [wpengine.com](http://wpengine.com) (that probably also is using HyperDB or a similar approach).
- Changed: Loggers now get default capability "manage_options" if they have no capability set.
- Changed: Misc internal cleanup.
- Removed: filter `simple_history/loggers_dir` removed, because loggers are loaded from array instead of file listing generated from `glob()`. Should be (however to the eye non-noticeable) faster.

= 2.0.30 (May 2015) =

- Added: Username of logged events now link to that user's profile.
- Fixed: When expanding occasions the first loaded occasion was the same event as the one you expanded from, and the last occasion was missing. Looked extra stupid when only 1 occasion existed, and you clicked "show occasions" only to just find the same event again. So stupid. But fixed now!
- Fixed: If an event had many similar events the list of similar events could freeze the browser. ([17948 failed login attempts overnight](https://twitter.com/eskapism/status/595478847598002176) is not that uncommon it turns out!)
- Fixed: Some loggers were missing the "All"-message in the search.
- Changed: Hide some more keys and values by default in the context data popup.
- Changed: Use `truncate` instead of `delete` when clearing the database. Works much faster on large logs.

= 2.0.29 (April 2015) =

- Added: Introducing [Post "Quick Diff"](http://eskapism.se/blog/2015/04/quick-diff-shows-post-changes-in-wordpress/) – a very simple and efficient way to quickly see what’s been changed in a post. With Quick Diff you will in a glance see the difference between the title, permalink, content, publish date, post status, post author, or the template of the post. It's really a super simple and fast way to follow the work of your co-editors.
- Added: Filter to add custom HTML above and after the context data table. They are named `simple_history/log_html_output_details_single/html_before_context_table` and `simple_history/log_html_output_details_single/html_after_context_table` (and yes, I do fancy really long filter names).
- Added: Filters to control what to output in the data/context details table (the popup you see when you click the time of each event): `simple_history/log_html_output_details_table/row_keys_to_show` and `simple_history/log_html_output_details_table/context_keys_to_show`. Also added [two usage examples](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php) for the filters.
- Added: Filter `simple_history/log_insert_context` to control what gets saved to the context table. Example on usage for this is also available in the [example file](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php).
- Added: data attribute `data-ip-address-multiple` and class `SimpleHistoryLogitem--IPAddress-multiple` added for events that have more than one IP address detected. Happens when `http_x_forwarded_for` or similar headers are included in response.
- Updated: Danish translation updated.
- Fixed: Images in GitHub readme files are now displayed correctly.
- Fixed: Readme files to GitHub repositories ending with slash (/) now works correctly too.
- Fixed: IP Info popup is now again closeable with `ESC` key or with a click outside it.
- Fixed: Some enqueued scripts had double slashes in them.
- Fixed: Make sure [URLs from add_query_arg() gets escaped](https://make.wordpress.org/plugins/2015/04/20/fixing-add_query_arg-and-remove_query_arg-usage/).
- Fixed: Some other small things.

= 2.0.28 (April 2015) =

- Fixed: Do not try to load the Translation Install API if using WordPress before 4.0. Fixes https://github.com/bonny/WordPress-Simple-History/issues/67.
- Updated: German translation updated.

= 2.0.27 (April 2015) =

- Fixed: Even better support for plugins from GitHub with the `GitHub Plugin URI` header. Plugin install, deactivations, and activations should have correct view-info-links now.
- Updated: German translation updated.
- Updated: Swedish translation updated.

= 2.0.26 (March 2015) =

- Fixed: Plugin installs from wordpress.org would show "wordpress plugin directory" as their source file. Looked stupid. Fixed now!
- Added: `composer.json` added, so Simple History can be pulled in to other projects via [Composer](https://getcomposer.org/). Actually untested, but at least the file is there. Please let me know if it works! :)

= 2.0.25 (March 2015) =

- Added: Plugin installs now shows the source of the plugin. Supported sources are "WordPress plugin repository" and "uploaded ZIP archives".
- Added: Plugin installs via upload now shows the uploaded file name.
- Added: Support for showing plugin info-link for plugins from GitHub, installed with uploaded ZIP-archive. Only tested with a few plugins. Please let me know if it works or not!
- Fixed: Messages for disabled loggers was not shown.
- Fixed: An error when trying to show edit link for deleted comments.
- Fixed: Use a safer way to get editable roles. Hopefully fixes https://wordpress.org/support/topic/php-warnings-simpleloggerphp-on-line-162.
- Fixed: Some notice warnings from the comments logger.
- Changed: Some other small things too.

= 2.0.24 (March 2015) =

- Fixed: Plugin installs from uploaded ZIP files are now logged correctly. Fixes https://github.com/bonny/WordPress-Simple-History/issues/59.
- Fixed: Check that JavaScript variables it set and that the object have properties set. Fixes https://wordpress.org/support/topic/firefox-37-js-error-generated-by-simplehistoryipinfodropinjs.
- Updated: German translation updated.
- Changed: Loading of loggers, dropins, and so one are moved from action `plugins_loaded` to `after_setup_theme` so themes can actually use for example the load*dropin*\*-filters...
- Changed: Misc small design fixes.

= 2.0.23 (March 2015) =

- Added: Filter `simple_history/rss_item_link`, so plugins can modify the link used in the RSS feed.
- Added: Links for changed posts and attachments in RSS feed now links directly to WordPress admin, making is easier to follow things from your RSS reeder.
- Added: Filters to hide history dashboard widget and history dashboard page. Filters are `simple_history/show_dashboard_widget` and `simple_history/show_dashboard_page`.
- Fixed: A missing argument error when deleting a plugin. Fixes https://wordpress.org/support/topic/warning-missing-argument-1-for-simplepluginlogger.

= 2.0.22 (February 2015) =

- Fixed: Deleted plugins were not logged correctly (name and other info was missing).
- Added: Filter `simple_history/logger/load_logger` and `simple_history/dropin/load_dropin` that can be used to control the loading of each logger or dropin. See [example file](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php) for usage examples.
- Fixed: modal window with context data now works better on small screens.
- Changed: Misc internal changes.

= 2.0.21 (February 2015) =

- Added: Updates via XML RPC are now logged, for example when using the WordPress app for iOS or Android. Supported actions for now is post/page created, edited, deleted, and media uploads.
- Added: `_xmlrpc_request` is added to context of event when an event is initiated through a XML-RPC all.
- Changed: RSS feed now has loglevel of event prepended to the title.
- Changed: Options logger now only shows the first 250 chars of new and old option values. Really long values could make the log look strange.
- Added: If constant `SIMPLE_HISTORY_LOG_DEBUG` is defined and true automatically adds `$_GET`, `$_POST`, and more info to each logged event. Mostly useful for the developer, but maybe some of you are a bit paranoid and want it too.
- Updated: German translation updated.

= 2.0.20 (February 2015) =

- Added: changes via [WP-CLI](http://wp-cli.org) is now detected (was previously shown as "other").
- Added: severity level (info, warning, debug, etc.) of event is includes in the RSS output.
- Changed the way user login is logged. Should fix https://github.com/bonny/WordPress-Simple-History/issues/40 + possible more related issues.
- Added: filter `simple_history/simple_logger/log_message_key` added, that can be used to shortcut log messages. See [example file](https://github.com/bonny/WordPress-Simple-History/blob/master/examples/examples.php) for usage. Fixes https://wordpress.org/support/topic/stop-logging-certain-types-of-activity.
- Added: now uses object caching at some places. Should speed up some parts of the plugin for users with caching enabled.
- Fixed: IP info popup can now be closed with `esc`.
- Fixed: works better on small screens (like mobile phones) + misc other style related fixes.

= 2.0.19 (February 2015) =

- Added: Dutch translation by [https://github.com/niknetniko](https://github.com/niknetniko). Thanks!
- Changed: better compatibility with plugins like [WP User Avatar](https://wordpress.org/plugins/wp-user-avatar/).
- Updated: German translation update.

= 2.0.18 (January 2015) =

- Fixed: really correctly show the version number of the previous version!

= 2.0.17 (January 2015) =

- Added: messages added using for example `SimpleLogger()->info( __("My log message") )` that have translations now auto translated the message back to english before storing the message (together with the text domain). Then upon retrieval it uses the english message + the text domain to translate the message to the currently selected language. This makes it easier to make multilingual log entries. (Yeah, I know its hard to understand what the heck this does, but it's something good and cool, trust me!)
- Added: A sidebar with text contents on the history page.
- Changed: Search now shows only the search box by default, with a link to show all search options.
- Fixed: Search is now available at the dashboard again. Hooray!
- Fixed: Old entries were not cleared automatically. Now it correctly removes old events, so your database will not risk growing to large.
- Fixed: Quick stats could show two messages sometimes.
- Fixed: When headers like `HTTP_X_FORWARDED_FOR` exists all valid IPs in that header is now stored.
- Fixed: Plugin updates via third party software like [InfiniteWP](http://infinitewp.com/) should now correctly show the version number of the previous version.
- Updated: German translation updated.
- Notice: Do you read these messages? Then you must love this plugin! Come on then, [go and give it a nice review](https://wordpress.org/support/view/plugin-reviews/simple-history).

= 2.0.16 (January 2015) =

- Fixed: Use the [X-Forwarded-For header](http://en.wikipedia.org/wiki/X-Forwarded-For), if it is set, to determine remote IP address. Should now correctly store IP addresses for servers behind load balancers or for clients going through proxies. Fixes https://wordpress.org/support/topic/use-x-forwarded-for-http-header-when-logging-remote_addr.
- Changed: Failed login attempts from unknown and known users are now grouped together. This change was made because a hacker could make many login attempts to a site and rotate the logins, so they would try with both existing and non existing user names, which would make the log flood with failed login attempts.
- Changed: use "n similar events" instead of "n more", to more clearly mark that the grouped events are not necessary exactly the same kind.
- Changed: Quick stats text changed, to also include other sources. Previous behavior was to only include events from WordPress users, but now also events from anonymous users and WordPress (like from WP-Cron) are included.

= 2.0.15 (January 2015) =

- Fixed: Widget changes where not always translated.
- Fixed: More RSS fixes to make feed valid. Maybe even for real this time.
- Updated: German translation updated.

= 2.0.14 (January 2015) =

- Added: Danish translation added. Thanks [ThomasDK81](https://github.com/ThomasDK81)!
- Misc translation fixes, for example the log levels where not translateable (it may be a good idea to keep the original English ones however because they are the ones that are common in other software).

= 2.0.13 (January 2015) =

- Fixed: RSS feed is now valid according to http://validator.w3.org/. Fixes https://wordpress.org/support/topic/a-feed-which-was-valid-under-v206-is-no-longer-under-v209-latest.
- Translation fixes. Thanks [ThomasDK81](https://github.com/ThomasDK81)!

= 2.0.12 (January 2015) =

- Fixed: Deleted attachments did not get translations.
- Fixed: A notice when showing details for a deleted attachment.

= 2.0.11 (January 2015) =

- Fixed: Comments where not logged correctly.
- Fixed: Comments where not translated correctly.
- Updated: German translation updated.

= 2.0.10 (January 2015) =

- Updated: Polish translation updated. Thanks [https://github.com/m-czardybon](m-czardybon)!
- Updated: German translation updated. Thanks [http://klein-aber-fein.de/](Ralph)!
- Updated: Swedish translation updated.

= 2.0.9 (December 2014) =

- Actually enable IP address lookup for all users. Sorry for missing to do that! ;)

= 2.0.8 (December 2014) =

- Added: IP addresses can now be clicked to view IP address info from [ipinfo.io](http://ipinfo.io). This will get you the location and network of an IP address and help you determine from where for example a failed login attempt originates from. [See screenshot of IP address info in action](http://glui.me/?d=y89nbgmvmfnxl4r/ip%20address%20information%20popup.png/).
- Added: new action `simple_history/admin_footer`, to output HTML and JavaScript in footer on pages that belong to Simple History
- Added: new trigger for JavaScript: `SimpleHistory:logReloadStart`. Fired when the log starts to reload, like when using the pagination or using the filter function.
- Fixed: use Mustache-inspired template tags instead of Underscore default ones, because they don't work with PHP with asp_tags on.
- Updated: Swedish translation updated

= 2.0.7 (December 2014) =

- Fix: no message when restoring page from trash
- Fix: use correct width for media attachment
- Add: filter `simple_history/logrowhtmloutput/classes`, to modify HTML classes added to each log row item

= 2.0.6 (November 2014) =

- Added: [WordPress 4.1 added the feature to log out a user from all their sessions](http://codex.wordpress.org/Version_4.1#Users). Simple History now logs when a user is logged out from all their sessions except the current browser, or if an admin destroys all sessions for a user. [View screenshot of new session logout log item](https://dl.dropboxusercontent.com/s/k4cmfmncekmfiib/2014-12-simple-history-changelog-user-sessions.png)

- Added: filter to shortcut loading of a dropin. Example that completely skips loading the RSS-feed-dropin:
  `add_filter("simple_history/dropin/load_dropin_SimpleHistoryRSSDropin", "__return_false");`

= 2.0.5 (November 2014) =

- Fix undefined variable in plugin logger. Fixes https://wordpress.org/support/topic/simple-history-201-is-not-working?replies=8#post-6343684.
- Made the dashboard smaller
- Misc other small GUI changes

= 2.0.4 (November 2014) =

- Make messages for manually updated plugins and bulk updated plugins more similar

= 2.0.3 (November 2014) =

- Show the version of PHP that the user is running, when the PHP requirement of >= 5.3 is not met

= 2.0.2 (November 2014) =

- Fixed wrong number of arguments used in filter in RSS-feed

= 2.0.1 (November 2014) =

- Removed anonymous function in index file causing errors during install on older versions of PHP

= 2.0 (November 2014) =

Major update - Simple History is now better and nicer than ever before! :)
I've spend hundreds of hours making this update, so if you use it and like it please [donate to keep my spirit up](http://eskapism.se/sida/donate/) or [give it a nice review](https://wordpress.org/support/view/plugin-reviews/simple-history).

- Code cleanup and modularization
- Support for log contexts
- Kinda PSR-3-compatible :)
- Can handle larger logs (doesn't load whole log into memory any more)
- Use nonces at more places
- More filters and hooks to make it easier to customize
- Better looking! well, at least I think so ;)
- Much better logging system to make it much easier to create new loggers and to translate logs into different languages
- Features as plugins: more things are moved into modules/its own file
- Users see different logs depending on their capability, for example an administrator will see what plugins have been installed, but an editor will not see any plugin related logs
- Much much more.

= 1.3.11 =

- Don't use deprecated function get_commentdata(). Fixes https://wordpress.org/support/topic/get_commentdata-function-is-deprecated.
- Don't use mysql_query() directly. Fixes https://wordpress.org/support/topic/deprecated-mysql-warning.
- Beta testers wanted! I'm working on the next version of Simple History and now I need some beta testers. If you want to try out the shiny new and cool version please download the [v2 branch](https://github.com/bonny/WordPress-Simple-History/tree/v2) over at GitHub. Thanks!

= 1.3.10 =

- Fix: correct usage of "its"
- Fix: removed serif font in log. Fixes https://wordpress.org/support/topic/two-irritations-and-pleas-for-change.

= 1.3.9 =

- Fixed strict standards warning
- Tested on WordPress 4.0

= 1.3.8 =

- Added filter for rss feed: `simple_history/rss_feed_show`. Fixes more things in this thread: http://wordpress.org/support/topic/more-rss-feed-items.

= 1.3.7 =

- Added filter for rss feed: `simple_history/rss_feed_args`. Fixes http://wordpress.org/support/topic/more-rss-feed-items.

= 1.3.6 =

- Added Polish translation
- Added correct XML encoding and header
- Fixed notice warnings when media did not exist on file system

= 1.3.5 =

- Added a reload-button at top. Click it to reload the history. No need to refresh page no more!
- Fixed items being reloaded when just clicking the dropdown (not having selected anything yet)
- Fixed bug with keyboard navigation
- Added Portuguese translation by [X6Web](http://x6web.com)
- Use less SQL queries

= 1.3.4 =

- Changed the way post types show in the dropdown. Now uses plural names + not prefixed with main post type. Looks better I think. Thank to Hassan for the suggestion!
- Added "bytes" to size units that an attachment can have. Also fixes undefined notice warning when attachment had a size less that 1 KB.

= 1.3.3 =

- Capability for viewing settings changed from edit_pages to the more correct [manage_options](http://codex.wordpress.org/Roles_and_Capabilities#manage_options)

= 1.3.2 =

- Could get php notice warning if rss secret was not set. Also: make sure both public and private secret exists.

= 1.3.1 =

- Improved contrast for details view
- Fix sql error on installation due to missing column
- Remove options and database table during removal of plugin
- Added: German translation for extender module

= 1.3 =

- Added: history events can store text description with a more detailed explanation of the history item
- Added: now logs failed login attempts for existing username. Uses the new text description to store more info, for example user agent and remote ip address (REMOTE_ADDR)
- Fixed: box did not change height when clicking on occasions
- Fixed: use on() instead of live() in JavaScript

= 1.2 =

- Fixed: Plugin name is included when plugins is activated or deactivated. Previously only folder name and name of php file was included.
- Added: Attachment thumbnails are now visible if history item is an attachment. Also includes some metadata.
- Changed: Filters now use dropdowns for type and user. When a site had lots of users and lots of post types, the filter section could be way to big.
- Added keyboard navigation. Use right and left arrow when you are on Simple History's own page to navigation between next and previous history page.
- Added loading indicator, so you know it's grabbing your history, even if it's taking a while
- Misc JS and CSS fixes
- Arabic translation updated
- POT-file updated

= 1.1 =

- Added the Simple History Extender-module/plugin. With this great addon to Simple History it is very easy for other developers to add their own actions to simple history, including a settings panel to check actions on/off. All work on this module was made by Laurens Offereins (lmoffereins@gmail.com). Super thanks!
- With the help of Simple History Extender this plugin also tracks changes made in bbPress, Gravity Forms and in Widges. Awesome!
- Added user email to RSS feed + some other small changed to make it compatible with IFTTT.com. Thanks to phoenixMagoo for the code changes. Fixes http://wordpress.org/support/topic/suggestions-a-couple-of-tweaks-to-the-rss-feed.
- Added two filters for the RSS feed: simple_history_rss_item_title and simple_history_rss_item_description.
- Changed the way the plugin directory was determined. Perhaps and hopefully this fixes some problems with multi site and plugin in different locations and stuff like that
- Style fixes for RTL languages
- Small fixes here and there, for example changing deprecated WordPress functions to not deprecated
- Added new filter: simple_history_db_purge_days_interval. Hook it to change default clear interval of 60 days.

= 1.0.9 =

- Added French translation

= 1.0.8 =

- Added: filter simple_history_allow_db_purge that is used to determine if the history should be purged/cleaned after 60 days or not. Return false and it will never be cleaned.
- Fixed: fixed a security issue with the RSS feed. User who should not be able to view the feed could get access to it. Please update to this version to keep your change log private!

= 1.0.7 =

- Fixed: Used a PHP shorthand opening tag at a place. Sorry!
- Fixed: Now loads scripts and styles over HTTPS, if that's being used. Thanks to "llch" for the patch.

= 1.0.6 =

- Added: option to set number of items to show, per page. Default i 5 history log items.

= 1.0.5 =

- Fixed: some translation issues, including updated POT-file for translators.

= 1.0.4 =

- You may want to clear the history database after this update because the items in the log will have mixed translate/untranslated status and it may look/work a bit strange.
- Added: Option to clear the database of log items.
- Changed: No longer stored translated history items in the log. This makes the history work even if/when you switch language of WordPress.
- Fixed: if for example a post was editied several times and during these edits it changed name, it would end up at different occasions. Now it's correctly stored as one event with several occasions.
- Some more items are translateable

= 1.0.3 =

- Updated German translation
- Some translation fixes

= 1.0.2 =

- Fixed a translation bug
- Added updated German translation

= 1.0.1 =

- The pagination no longer disappear after clickin "occasions"
- Fixed: AJAX loading of new history items didn't work.
- New filter: simple_history_view_history_capability. Default is "edit_pages". Modify this to change what cabability is required to view the history.
- Modified: styles and scripts are only added on pages that use/show Simple History
- Updated: new POT file. So translators my want to update their translations...

= 1.0 =

- Added: pagination. Gives you more information, for example the number of items, and quicker access to older history items. Also looks more like the rest of the WordPress GUI.
- Modified: search now searches type of action (added, modified, deleted, etc.).

= 0.8.1 =

- Fixed some annoying errors that slipt through testing.

= 0.8 =

- Added: now also logs when a user saves any of the built in settings page (general, writing, reading, discussion, media, privacy, and permalinks. What more things do you want to see in the history? Let me know in the [support forum](http://wordpress.org/support/plugin/simple-history).
- Added: gravatar of user performing action is always shown
- Fixed: history items that was posts/pages/custom post types now get linked again
- Fixed: search is triggered on enter (no need to press search button) + search searches object type and object subtype (before it just searched object name)
- Fixed: showing/loading of new history items was kinda broken. Hopefully fixed and working better than ever now.
- Plus: even more WordPress-ish looking!
- Also added donate-links. Tried to keep them discrete. Anyway: please [donate](http://eskapism.se/sida/donate/?utm_source=wordpress&utm_medium=changelog&utm_campaign=simplehistory) if you use this plugin regularly.

= 0.7.2 =

- Default settings should be to show on page, missed that one. Sorry!

= 0.7.1 =

- Fixed a PHP shorttag

= 0.7 =

- Do not show on dashboard by default to avoid clutter. Can be enabled in settings.
- Add link to settings from plugin list
- Settings are now available as it's own page under Settings -> Simple Fields. It was previously on the General settings page and some people had difficulties finding it there.
- Added filters: simple_history_show_settings_page, simple_history_show_on_dashboard, simple_history_show_as_page

= 0.6 =

- Changed widget name to just "History" instead of "Simple History". Keep it simple. Previous name implied there also was an "Advanced History" somewhere.
- Made the widget look a bit WordPress-ish by borrwing some of the looks from the comments widget.
- Fix for database that didn't use UTF-8 (sorry international users!)
- Some security fixes
- Updated POT-file

= 0.5 =

- Added author to RSS
- Added german translation, thanks http://www.fuerther-freiheit.info/
- Added swedish translation, thanks http://jockegustin.se
- Better support for translation

= 0.4 =

- Added: Now you can search the history
- Added: Choose if you wan't to load/show more than just 5 rows from the history

= 0.3.11 =

- Fixed: titles are now escaped

= 0.3.10 =

- Added chinese translation
- Fixed a variable notice
- More visible ok-message after setting a new RSS secret

= 0.3.9 =

- Attachment names were urlencoded and looked weird. Now they're not.
- Started to store plugin version number

= 0.3.8 =

- Added chinese translation
- Uses WordPress own human_time_diff() instead of own version
- Fix for time zones

= 0.3.7 =

- Directly after installation of Simple History you could view the history RSS feed without using any secret. Now a secret is automatically set during installation.

= 0.3.6 =

- Made the RSS-feature a bit easier to find: added a RSS-icon to the dashboard window - it's very discrete, you can find it at the bottom right corner. On the Simple History page it's a bit more clear, at the bottom, with text and all. Enjoy!
- Added POT-file

= 0.3.5 =

- using get_the_title instead of fetching the title directly from the post object. should make plugins like qtranslate work a bit better.
- preparing for translation by using \_\_() and \_e() functions. POT-file will be available shortly.
- Could get cryptic "simpleHistoryNoMoreItems"-text when loading a type with no items.

= 0.3.4 =

- RSS-feed is now valid, and should work at more places (could be broken because of html entities and stuff)

= 0.3.3 =

- Moved JavaScript to own file
- Added comments to the history, so now you can see who approved a comment (or unapproved, or marked as spam, or moved to trash, or restored from the trash)

= 0.3.2 =

- fixed some php notice messages + some other small things I don't remember..

= 0.3.1 =

- forgot to escape html for posts
- reduced memory usage... I think/hope...
- changes internal verbs for actions. some old history items may look a bit weird.
- added RSS feed for recent changes - keep track of changes via your favorite RSS-reader

= 0.3 =

- page is now added under dashboard (was previously under tools). just feel better.
- mouse over on date now display detailed date a bit faster
- layout fixes to make it cooler, better, faster, stronger
- multiple events of same type, performed on the same object, by the same user, are now grouped together. This way 30 edits on the same page does not end up with 30 rows in Simple History. Much better overview!
- the name of deleted items now show up, instead of "Unknown name" or similar
- added support for plugins (who activated/deactivated what plugin)
- support for third party history items. Use like this:
  simple_history_add("action=repaired&object_type=starship&object_name=USS Enterprise");
  this would result in something like this:
  Starship "USS Enterprise" repaired
  by admin (John Doe), just now
- capability edit_pages needed to show history. Is this an appropriate capability do you think?

= 0.2 =

- Compatible with 2.9.2

= 0.1 =

- First public version. It works!
