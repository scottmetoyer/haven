<style>
    :root {
        @foreach(theme()->colors() as $name => $value)
        --color-{{ $name }}: {{ $value }};
        @endforeach
    }

    /* Theme utility classes */
    .bg-primary { background-color: var(--color-primary); }
    .bg-secondary { background-color: var(--color-secondary); }
    .bg-accent { background-color: var(--color-accent); }

    .text-primary { color: var(--color-primary); }
    .text-secondary { color: var(--color-secondary); }
    .text-accent { color: var(--color-accent); }

    .border-primary { border-color: var(--color-primary); }
    .border-secondary { border-color: var(--color-secondary); }
    .border-accent { border-color: var(--color-accent); }

    .hover\:bg-primary:hover { background-color: var(--color-primary); }
    .hover\:text-primary:hover { color: var(--color-primary); }
</style>
