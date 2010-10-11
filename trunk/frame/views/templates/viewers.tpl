<h3>people who read this:</h3>
{foreach from=$viewers key=n item=viewer}
{$viewer.email|@htmlentities}<br>
{/foreach}
