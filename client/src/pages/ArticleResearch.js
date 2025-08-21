import React, { useState } from 'react';
import { 
  Box, 
  Button, 
  Card, 
  CardContent, 
  CircularProgress, 
  Divider, 
  Grid, 
  IconButton, 
  InputAdornment, 
  List, 
  ListItem, 
  ListItemText, 
  Paper, 
  TextField, 
  Typography 
} from '@mui/material';
import SearchIcon from '@mui/icons-material/Search';
import OpenInNewIcon from '@mui/icons-material/OpenInNew';
import BookmarkBorderIcon from '@mui/icons-material/BookmarkBorder';
import BookmarkIcon from '@mui/icons-material/Bookmark';
import axios from 'axios';
import ResponsiveContainer from '../components/layout/ResponsiveContainer';
import AccessibleTable from '../components/common/AccessibleTable';
import { announceToScreenReader, handleListKeyboardNavigation } from '../utils/accessibilityUtils';

const ArticleResearch = () => {
  const [searchQuery, setSearchQuery] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [articles, setArticles] = useState([]);
  const [error, setError] = useState('');
  const [savedArticles, setSavedArticles] = useState([]);

  const handleSearch = async (e) => {
    e.preventDefault();
    if (!searchQuery.trim()) return;

    setIsLoading(true);
    setError('');
    
    // Announce to screen readers that search is in progress
    announceToScreenReader('Searching for articles, please wait...');
    
    try {
      const response = await axios.get(`/api/articles/search?query=${encodeURIComponent(searchQuery)}`);
      setArticles(response.data);
      
      // Announce results to screen readers
      announceToScreenReader(`Found ${response.data.length} articles related to ${searchQuery}`);
    } catch (err) {
      console.error('Error searching articles:', err);
      setError('Failed to fetch articles. Please try again.');
      setArticles([]);
      announceToScreenReader('Error searching for articles. Please try again.');
    } finally {
      setIsLoading(false);
    }
  };

  const toggleSaveArticle = (articleId) => {
    if (savedArticles.includes(articleId)) {
      setSavedArticles(savedArticles.filter(id => id !== articleId));
    } else {
      setSavedArticles([...savedArticles, articleId]);
    }
  };

  const openArticle = (pmid) => {
    window.open(`https://pubmed.ncbi.nlm.nih.gov/${pmid}`, '_blank');
  };

  return (
    <ResponsiveContainer sx={{ py: 4 }}>
      <Typography 
        variant="h3" 
        component="h1" 
        align="center" 
        sx={{ 
          mb: 1, 
          fontWeight: 700,
          color: 'primary.main'
        }}
        id="article-research-heading"
      >
        Article Research
      </Typography>
      
      <Typography 
        variant="h6" 
        align="center" 
        color="textSecondary" 
        sx={{ mb: 4 }}
      >
        Search the latest scientific publications on photodynamic therapy
      </Typography>

      <Paper 
        component="form" 
        onSubmit={handleSearch}
        elevation={3} 
        sx={{ 
          p: 3, 
          mb: 4, 
          maxWidth: 800, 
          mx: 'auto',
          borderRadius: 2
        }}
      >
        <Typography variant="h6" sx={{ mb: 2 }}>
          Search PubMed Database
        </Typography>
        
        <TextField
          fullWidth
          label="Search for PDT research"
          variant="outlined"
          value={searchQuery}
          onChange={(e) => setSearchQuery(e.target.value)}
          placeholder="e.g., oral cancer photodynamic therapy PpIX"
          InputProps={{
            endAdornment: (
              <InputAdornment position="end">
                <Button 
                  variant="contained" 
                  color="primary" 
                  onClick={handleSearch}
                  disabled={isLoading || !searchQuery.trim()}
                  sx={{ px: 3, py: 1.5 }}
                  aria-live="polite"
                  aria-busy={isLoading}
                >
                  {isLoading ? <CircularProgress size={24} color="inherit" /> : <SearchIcon />}
                  {isLoading ? 'Searching...' : 'Search'}
                </Button>
              </InputAdornment>
            ),
          }}
          sx={{ mb: 2 }}
          id="article-search-input"
          aria-label="Search for PDT research articles"
        />
        
        <Typography variant="body2" color="textSecondary">
          Results will be filtered for photodynamic therapy and related topics
        </Typography>
      </Paper>

      {error && (
        <Typography color="error" align="center" sx={{ my: 2 }}>
          {error}
        </Typography>
      )}

      {isLoading ? (
        <Box sx={{ display: 'flex', justifyContent: 'center', my: 4 }}>
          <CircularProgress />
        </Box>
      ) : articles.length > 0 ? (
        <Grid container spacing={3}>
          <Grid item xs={12} md={8}>
            <Typography variant="h5" sx={{ mb: 2, fontWeight: 600 }}>
              Search Results
            </Typography>
            
            <List sx={{ bgcolor: 'background.paper' }}>
              {articles.map((article) => (
                <React.Fragment key={article.pmid}>
                  <ListItem 
                    alignItems="flex-start"
                    secondaryAction={
                      <Box>
                        <IconButton 
                          edge="end" 
                          aria-label={savedArticles.includes(article.pmid) ? 'Remove from saved articles' : 'Save article'}
                          onClick={() => {
                            toggleSaveArticle(article.pmid);
                            announceToScreenReader(savedArticles.includes(article.pmid) ? 
                              'Article removed from saved articles' : 'Article saved to your collection');
                          }}
                          color={savedArticles.includes(article.pmid) ? 'primary' : 'default'}
                        >
                          {savedArticles.includes(article.pmid) ? <BookmarkIcon /> : <BookmarkBorderIcon />}
                        </IconButton>
                        <IconButton 
                          edge="end" 
                          aria-label="Open article in new tab" 
                          onClick={() => openArticle(article.pmid)}
                          color="primary"
                        >
                          <OpenInNewIcon />
                        </IconButton>
                      </Box>
                    }
                    sx={{ pr: 12 }}
                    role="article"
                    tabIndex={0}
                  >
                    <ListItemText
                      primary={
                        <Typography variant="h6" component="div" sx={{ fontWeight: 500 }}>
                          {article.title}
                        </Typography>
                      }
                      secondary={
                        <React.Fragment>
                          <Typography
                            component="span"
                            variant="body2"
                            color="text.primary"
                            sx={{ display: 'block', mt: 1 }}
                          >
                            {article.authors.join(', ')}
                          </Typography>
                          <Typography
                            component="span"
                            variant="body2"
                            color="text.secondary"
                            sx={{ display: 'block', mt: 0.5 }}
                          >
                            {article.journal} • {article.year} • PMID: {article.pmid}
                          </Typography>
                          {article.abstract && (
                            <Typography
                              component="span"
                              variant="body2"
                              color="text.secondary"
                              sx={{ display: 'block', mt: 1 }}
                            >
                              {article.abstract.substring(0, 250)}...
                            </Typography>
                          )}
                        </React.Fragment>
                      }
                    />
                  </ListItem>
                  <Divider component="li" />
                </React.Fragment>
              ))}
            </List>
          </Grid>
          
          <Grid item xs={12} md={4}>
            <Card sx={{ mb: 3 }}>
              <CardContent>
                <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                  Search Tips
                </Typography>
                <Typography variant="body2" paragraph>
                  • Use specific terms related to PDT
                </Typography>
                <Typography variant="body2" paragraph>
                  • Include photosensitizer names (e.g., PpIX, Photofrin)
                </Typography>
                <Typography variant="body2" paragraph>
                  • Specify cancer types (e.g., oral, squamous cell)
                </Typography>
                <Typography variant="body2" paragraph>
                  • Add technical terms (e.g., fluorescence, dosimetry)
                </Typography>
              </CardContent>
            </Card>
            
            <Card>
              <CardContent>
                <Typography variant="h6" sx={{ mb: 2, fontWeight: 600 }}>
                  Saved Articles
                </Typography>
                {savedArticles.length > 0 ? (
                  <List dense>
                    {savedArticles.map(id => {
                      const article = articles.find(a => a.pmid === id);
                      return article ? (
                        <ListItem key={id} disablePadding>
                          <ListItemText 
                            primary={article.title}
                            secondary={`${article.authors[0]} et al., ${article.year}`}
                            primaryTypographyProps={{ variant: 'body2', fontWeight: 500 }}
                            secondaryTypographyProps={{ variant: 'caption' }}
                          />
                          <IconButton size="small" onClick={() => openArticle(id)}>
                            <OpenInNewIcon fontSize="small" />
                          </IconButton>
                        </ListItem>
                      ) : null;
                    })}
                  </List>
                ) : (
                  <Typography variant="body2" color="textSecondary">
                    No saved articles yet. Click the bookmark icon to save articles for later reference.
                  </Typography>
                )}
              </CardContent>
            </Card>
          </Grid>
        </Grid>
      ) : (
        <Box sx={{ textAlign: 'center', my: 8 }}>
          <SearchIcon sx={{ fontSize: 60, color: 'text.secondary', opacity: 0.3, mb: 2 }} />
          <Typography variant="h6" color="textSecondary">
            Enter a search term to find relevant PDT research articles
          </Typography>
        </Box>
      )}
    </ResponsiveContainer>
  );
};

export default ArticleResearch;