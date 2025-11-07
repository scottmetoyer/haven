<?php

namespace App\Livewire\Admin;

use App\Jobs\GenerateArticleFromScrapedContent;
use App\Models\ScrapedContent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ScrapedContentReview extends Component
{
    use WithPagination;

    public $selectedContent = [];
    public $showModal = false;
    public $aiPrompt = '';
    public $search = '';
    public $sortField = 'discovered_at';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleSelection($contentId)
    {
        if (in_array($contentId, $this->selectedContent)) {
            $this->selectedContent = array_diff($this->selectedContent, [$contentId]);
        } else {
            $this->selectedContent[] = $contentId;
        }
    }

    public function openModal()
    {
        if (empty($this->selectedContent)) {
            session()->flash('error', 'Please select at least one scraped content item.');
            return;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->aiPrompt = '';
    }

    public function generateArticle()
    {
        $this->validate([
            'aiPrompt' => 'required|min:10',
        ]);

        if (empty($this->selectedContent)) {
            session()->flash('error', 'Please select at least one scraped content item.');
            return;
        }

        try {
            // Dispatch the job to the queue
            GenerateArticleFromScrapedContent::dispatch(
                $this->selectedContent,
                $this->aiPrompt,
                Auth::id()
            );

            session()->flash('success', 'Article generation job has been queued! The selected content will be processed shortly.');

            // Reset state
            $this->selectedContent = [];
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to queue article generation: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Show all scraped content with search and sorting
        // Items with no articles will show a "NEW" pill
        $query = ScrapedContent::with(['affiliateSite', 'articles']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content_url', 'like', '%' . $this->search . '%')
                    ->orWhere('content_identifier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('affiliateSite', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply sorting
        if ($this->sortField === 'source') {
            $query->join('affiliate_sites', 'scraped_contents.affiliate_site_id', '=', 'affiliate_sites.id')
                ->select('scraped_contents.*')
                ->orderBy('affiliate_sites.name', $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $scrapedContents = $query->paginate(20);

        $selectedScrapedContents = ScrapedContent::with('affiliateSite')
            ->whereIn('id', $this->selectedContent)
            ->get();

        return view('livewire.admin.scraped-content-review', [
            'scrapedContents' => $scrapedContents,
            'selectedScrapedContents' => $selectedScrapedContents,
        ]);
    }
}
