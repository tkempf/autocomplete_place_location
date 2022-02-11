# AutoCompletePlaceLocation Module for Webtrees

This module makes the autocomplete function for places to search the
geographic data table place_location. This allows you to import geographic data
i.e. from <https://webtrees.net/download/locations> via webtrees import function
and delivers autocomplete propositions based on this data, which should help
to keep the place records in your gedcom more consistent.

Be aware, that the module could lead to the following privacy issue as stated by Greg in the forums: 

If you do not import geographic data, the wt_place_locations table contains all places from all trees 
If you use it for auto-complete, then a user in one tree could find all the places in another (private) tree.

For installation, just copy the files to your modules_v4 folder and enable the module via Administration Interface

