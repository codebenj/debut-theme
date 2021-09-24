 <table class="table table-bordered table-hover mb-0">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Date added</th>
            <th scope="col">Version</th>
            <th scope="col">Link</th>
            <th scope="col">Beta theme</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($themes as $theme)
          <tr>
            <th scope="row">{{ $theme->id }}</th>
            <td>{{ date('M d Y', strtotime($theme->created_at)) }} </td>
            <td>Debutify {{ $theme->version }}</td>
            <td><a href="{{ $theme->url }}" target="_blank">{{ $theme->url }}</td>
              @php
                  $checked = "";
                if($theme->is_beta_theme == 1){
                    $checked = "checked";
                }
              @endphp
              <td><input type="checkbox" name="checkbox" class="is_beta_theme" value="value" name="is_beta_theme" data-id="{{ $theme->id }}" data-version="{{ $theme->version }}" {{ $checked }}></td>
          </tr>
          @endforeach
        </tbody>
      </table>