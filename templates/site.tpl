<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Acupunctura - Medecine chinoise millénaire</title>
    <base href="{$route}" />
    <meta content="Acupunctura - Medecine chinoise millénaire" name="description">
    <link type="text/css" rel="stylesheet" href="/media/css/jquery-ui-git.css">
    <link type="text/css" rel="stylesheet" href="/media/css/select2.min.css">
    <link type="text/css" rel="stylesheet" href="/media/css/site.css">
    <link type="text/css" rel="stylesheet" href="/media/css/jquery.dataTables.min.css">
    <script  type="text/javascript" charset="UTF-8" src="/media/javascript/jquery-1.12.0.min.js"></script>
    <script  type="text/javascript" charset="UTF-8" src="/media/javascript/jquery-ui.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="/media/javascript/select2.full.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="/media/javascript/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="/media/javascript/site.js"></script>
  </head>
  <body>
        {include file='header.tpl' user=$user}
        {include file="$module" argument=$argument user=$user}
        {include file='footer.tpl'}
        <div id="popup"></div>
  </body>
</html>