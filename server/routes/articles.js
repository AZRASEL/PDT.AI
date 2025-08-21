const express = require('express');
const router = express.Router();
const axios = require('axios');

/**
 * @route   GET api/articles/search
 * @desc    Search for articles using PubMed API
 * @access  Public
 */
router.get('/search', async (req, res) => {
  try {
    const { query, limit = 10 } = req.query;
    
    if (!query) {
      return res.status(400).json({ msg: 'Query parameter is required' });
    }

    // PubMed API search
    // Using E-utilities API: https://www.ncbi.nlm.nih.gov/books/NBK25500/
    const searchResponse = await axios.get(
      `https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi`,
      {
        params: {
          db: 'pubmed',
          term: `${query} AND ("photodynamic therapy"[MeSH Terms] OR "photodynamic therapy"[All Fields] OR "PDT"[All Fields])`,
          retmode: 'json',
          retmax: limit,
          sort: 'relevance'
        }
      }
    );

    const ids = searchResponse.data.esearchresult.idlist;

    if (ids.length === 0) {
      return res.json({ articles: [] });
    }

    // Fetch article details
    const summaryResponse = await axios.get(
      `https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi`,
      {
        params: {
          db: 'pubmed',
          id: ids.join(','),
          retmode: 'json'
        }
      }
    );

    const result = summaryResponse.data.result;
    
    // Format the response
    const articles = ids.map(id => {
      const article = result[id];
      return {
        id,
        title: article.title,
        authors: article.authors ? article.authors.map(author => author.name).join(', ') : 'Unknown',
        journal: article.fulljournalname || article.source || 'Unknown',
        year: article.pubdate ? article.pubdate.split(' ')[0] : 'Unknown',
        abstract: article.abstract || '',
        url: `https://pubmed.ncbi.nlm.nih.gov/${id}/`
      };
    });

    res.json({ articles });
  } catch (err) {
    console.error('Error searching articles:', err.message);
    res.status(500).send('Server Error');
  }
});

/**
 * @route   GET api/articles/:id
 * @desc    Get article details by ID
 * @access  Public
 */
router.get('/:id', async (req, res) => {
  try {
    const { id } = req.params;
    
    // Fetch article details
    const response = await axios.get(
      `https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi`,
      {
        params: {
          db: 'pubmed',
          id,
          retmode: 'xml',
          rettype: 'abstract'
        }
      }
    );

    // For simplicity, we're just returning the XML response
    // In a production app, you would parse the XML and format it properly
    res.set('Content-Type', 'application/xml');
    res.send(response.data);
  } catch (err) {
    console.error('Error fetching article:', err.message);
    res.status(500).send('Server Error');
  }
});

module.exports = router;