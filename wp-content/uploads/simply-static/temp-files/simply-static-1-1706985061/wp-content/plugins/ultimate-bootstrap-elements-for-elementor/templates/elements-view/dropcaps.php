<p>#

dropcaps_sharp ='';

if ( settings.sharp !=='' ) {
dropcaps_sharp = 'sharp-' + settings.sharp;
}

view.addRenderAttribute( 'dropcaps_warpper', 'class',[
'ube-dropcaps',
'view-'+ settings.view,
dropcaps_sharp
] );

#>
</p>
<div view.getrenderattributestring>
<# if(  settings.dropcaps_text !=='' ){#>
<p>{{{ settings.dropcaps_text}}}</p>
<# }#>
</div>