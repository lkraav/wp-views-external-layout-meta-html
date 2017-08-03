# Toolset Views External Layout Meta HTML

Filter view layout HTML definition (aka template) with an external source,
like files.

If your theme has a directory `wp-views/` and a file `some-view-slug.html` in
there, we use this file and override Views admin template content.

Output is clearly annotated with HTML comments in the page source, so you know
exactly what template is being used and why.

## MOTIVATION

* Views templates get improvements over time, they should benefit all projects,
  even retroactively, with risk-free deployments.

* Standardized templates/configurations, like `display-child-pages` could now
  be pulled into themes declaratively w/ `{composer,package}.json`; each
  template could become an individual package/repo.

* Development workflow gains visibility into an infrastructure area previously
  in dark

* Views template editing doesn't have revisions, very difficult to assign blame
  or recover from mistakes


## TODO

* Generalize backend location infrastructure?

* Filter admin layout meta html box, insert clarity copy? ITMW, admin can
  manually insert a placeholder note.

* CSS + JS editor?
