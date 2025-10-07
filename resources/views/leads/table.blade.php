<div class="table-responsive">
    <table class="table align-middle table-nowrap" id="leadsTable">
        <thead class="text-muted">
            <tr>
                <th>Acciones</th>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Servicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody class="list form-check-all">
            @forelse($leads as $lead)
                <tr class="lead-row" data-lead-id="{{ $lead->id }}" style="background-color: {{ $lead->status ? $lead->status->color : '' }}; color: {{ $lead->status ? $lead->status->text_color : '' }};">
                    <td class="text-nowrap">
                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-primary btn-sm">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                        <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info btn-sm">
                            <i class="ri-eye-line"></i>
                        </a>
                    </td>
                    <td>{{ $lead->contact_date }}</td>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->email }}</td>
                    <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->service->name ?? '' }}</td>
                    <td class="status-cell">
                        <select class="form-select form-select-sm lead-status-select" data-update-url="{{ route('leads.updateStatus', $lead->id) }}">
                            @isset($statuses)
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" data-color="{{ $status->color }}" data-text-color="{{ $status->text_color }}" {{ $lead->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="{{ $lead->status_id }}" selected>{{ $lead->status->name ?? '' }}</option>
                            @endisset
                        </select>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
