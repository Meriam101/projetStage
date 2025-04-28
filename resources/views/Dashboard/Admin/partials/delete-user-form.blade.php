{{-- resources/views/profile/partials/delete-user-form.blade.php --}}

<section class="space-y-6">
    {{-- ... header and button ... --}}

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('admin.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            {{-- ... h2 and p tags ... --}}

            <div class="mt-6">
                {{-- MODIFIER L'ATTRIBUT 'for' ICI --}}
                <x-input-label for="delete_password" value="{{ __('Password') }}" class="sr-only" />

                {{-- MODIFIER L'ATTRIBUT 'id' ICI --}}
                <x-text-input
                    id="delete_password"
                    name="password" {{-- Gardez name="password", car c'est ce que le backend attend --}}
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                {{-- L'erreur est associée au nom du champ, pas besoin de changer ici --}}
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                {{-- ... buttons ... --}}
            </div>
        </form>
    </x-modal>
</section>