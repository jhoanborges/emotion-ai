import React from 'react';
import useSWR from 'swr';

function PostsComponent() {
    const { data: posts, error } = useSWR('/api/facebook/posts', fetcher); // Adjust URL as needed
    console.log('mounted!!')
    if (error) return <div>Error loading posts</div>;
    if (!posts) return <div>Loading...</div>;

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Facebook Posts</div>
                        <div className="card-body">
                            <ul className="list-group">
                                {posts.map(post => (
                                    <li key={post.id} className="list-group-item">
                                        <strong>{post.name}</strong>
                                        {post.description && <p>{post.description}</p>}
                                        {post.full_picture && <img src={post.full_picture} alt="Post" style={{ maxWidth: '100%' }} />}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PostsComponent;

// Example fetcher function for SWR
const fetcher = async (url) => {
    const response = await fetch(url);
    if (!response.ok) {
        throw new Error('Failed to fetch data');
    }
    return response.json();
};
