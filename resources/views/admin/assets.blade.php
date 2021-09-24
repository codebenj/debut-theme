<div class="list-group asset-list">
    @foreach($assets as $asset)
        <div class="list-group-item list-group-item-action">
            <a href="{{ $asset['url'] }}" target="_blank">
                {{ $asset['name'] }}
            </a>
            <button type="button" class="btn float-right py-0" onclick="return deleteAsset('{{ $asset['path'] }}', '{{ $asset['url'] }}', '{{ $asset['name'] }}');">
                <span class="fas fa-trash-alt"></span>
            </button>
        </div>
    @endforeach
</div>