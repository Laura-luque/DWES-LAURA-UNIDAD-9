<?php
use App\Models\Blog;

function tagsUnique(){
        $allTags = [];
        foreach (Blog::all() as $blog) {
            $tagsString = $blog->tags;
            $tags = explode(", ", $tagsString);
            foreach ($tags as $tag) {
                if (!in_array($tag, $allTags)) {
                    $allTags[] = $tag;
                }
            }
        }
        return $allTags;
}
interface UploadedFileInterface
{
    
    public function getStream(): StreamInterface;

    public function moveTo(string $targetPath): void;
    
    public function getSize(): ?int;
    
    public function getError(): int;
    
    public function getClientFilename(): ?string;
    
    public function getClientMediaType(): ?string;
}