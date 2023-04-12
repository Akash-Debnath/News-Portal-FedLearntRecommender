#!/usr/bin/env python
# coding: utf-8

# In[38]:


import numpy as np
import scipy
import pandas as pd
import math
import random
import sklearn
from nltk.corpus import stopwords
from scipy.sparse import csr_matrix
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from scipy.sparse.linalg import svds
from sklearn.preprocessing import MinMaxScaler
import matplotlib.pyplot as plt


# In[39]:


#Load data from user interactions dataset

interactions_df = pd.read_csv('/Users/akashchandradebnath/Sites/laravel-news-main/storage/app/public/usersdata.csv')
interactions_df.head(10)


# In[40]:


#Assign strength of each post by their reactions

event_type_strength = {
   'Views': 1.0,
   'Likes': 2.0, 
   'Comments': 4.0,  
}

interactions_df['eventStrength'] = interactions_df['Views']*event_type_strength['Views'] + interactions_df['Likes']*event_type_strength['Likes'] + interactions_df['Comments']*event_type_strength['Comments']

interactions_df.tail()


# In[42]:


#Data shape

interactions_df.shape


# In[43]:


interactions_df.insert(0,'ID',range(0,interactions_df.shape[0]))
interactions_df.head()


# In[44]:


#Count missing data
interactions_df.isna().sum()


# In[45]:


interactions_full_df = interactions_df[['ID', 'Post ID', 'eventStrength']]
interactions_full_df


# In[47]:


#Computes the most popular items

item_popularity_df = interactions_full_df.groupby('Post ID')['eventStrength'].sum().sort_values(ascending=False).reset_index()
item_popularity_df.head(5)

