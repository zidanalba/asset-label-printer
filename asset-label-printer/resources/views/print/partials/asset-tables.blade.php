@include('print.partials.asset-table', [
    'assets' => $assetsToPrint,
    'tableId' => 'printAssetsTable',
    'bulkBtnId' => 'printSelectedBtn',
    'bulkBtnLabel' => 'Print Selected Labels',
    'tabType' => 'print',
])

@include('print.partials.asset-table', [
    'assets' => $assetsToReprint,
    'tableId' => 'reprintAssetsTable',
    'bulkBtnId' => 'reprintSelectedBtn',
    'bulkBtnLabel' => 'Reprint Selected Labels',
    'tabType' => 'reprint',
]) 