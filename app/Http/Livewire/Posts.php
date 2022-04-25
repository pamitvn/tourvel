<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Posts extends Component
{
   public Collection|Post $posts;
   public int $pageNumber = 1;
   public bool $hasMorePages = true;

   public function mount()
   {
      $this->posts = new Collection();

      $this->loadMore();
   }

   public function loadMore()
   {
      $posts = Post::orderByDesc('created_at')->paginate(6, '*', 'page', $this->pageNumber);

      $this->pageNumber += 1;
      $this->hasMorePages = $posts->hasMorePages();

      $this->posts->push(...$posts->items());
   }

   public function render()
   {
      return view('livewire.posts');
   }
}
