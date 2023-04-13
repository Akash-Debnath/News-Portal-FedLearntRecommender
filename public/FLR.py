#!/usr/bin/env python
# coding: utf-8

# In[59]:


import pandas as pd
interactions_df = pd.read_csv('/Users/akashchandradebnath/Sites/laravel-news-main/storage/app/public/usersdata.csv')

event_type_strength = {
   'Views': 1.0,
   'Likes': 2.0, 
   'Comments': 4.0,  
}

interactions_df['eventStrength'] = interactions_df['Views']*event_type_strength['Views'] + interactions_df['Likes']*event_type_strength['Likes'] + interactions_df['Comments']*event_type_strength['Comments']
interactions_full_df = interactions_df[['Post ID', 'eventStrength']]

item_popularity_df = interactions_full_df.groupby('Post ID')['eventStrength'].sum().sort_values(ascending=False).reset_index()
item_popularity_df['Post ID'].head(1)


# In[ ]:




