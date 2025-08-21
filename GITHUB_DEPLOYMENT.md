# Detailed GitHub Deployment Guide for PDT.AI

This guide provides step-by-step instructions for deploying the PDT.AI application to GitHub Pages and running it from a GitHub repository.

## Prerequisites

- GitHub account
- Git installed on your local machine
- Node.js (v14 or higher) and npm (v6 or higher)
- PubMed API key (for article search functionality)

## Step 1: Fork or Clone the Repository

1. Go to the PDT.AI GitHub repository: https://github.com/yourusername/pdt-ai
2. Click the "Fork" button in the top-right corner to create your own copy of the repository
3. Alternatively, clone the repository directly:
   ```bash
   git clone https://github.com/yourusername/pdt-ai.git
   cd pdt-ai
   ```

## Step 2: Configure the Repository

1. Update the repository settings for GitHub Pages:
   - Go to your repository → Settings → Pages
   - Source: Deploy from a branch
   - Branch: gh-pages → /(root) → Save

2. Update the repository URL in the following files:
   - In `client/package.json`, update the "homepage" field:
     ```json
     "homepage": "https://yourusername.github.io/pdt-ai",
     ```
   - In `README.md`, update all instances of "yourusername" to your actual GitHub username

3. Set up the required secrets for GitHub Actions:
   - Go to your repository → Settings → Secrets and variables → Actions
   - Click "New repository secret"
   - Name: `PUBMED_API_KEY`
   - Value: Your actual PubMed API key
   - Click "Add secret"

## Step 3: Local Development and Testing

1. Install all dependencies:
   ```bash
   npm run install-all
   ```

2. Create a `.env` file in the root directory with the following variables:
   ```
   PORT=5000
   NODE_ENV=development
   PUBMED_API_KEY=your_pubmed_api_key
   ```

3. Start the development server:
   ```bash
   npm run dev
   ```

4. Test the application locally by navigating to `http://localhost:3000` in your browser

## Step 4: Commit and Push Changes

1. Make any necessary changes to the code

2. Commit your changes:
   ```bash
   git add .
   git commit -m "Initial setup for deployment"
   ```

3. Push to your GitHub repository:
   ```bash
   git push origin main
   ```

## Step 5: Automated Deployment with GitHub Actions

1. The GitHub Actions workflow will automatically trigger when you push to the main branch

2. You can monitor the deployment process:
   - Go to your repository → Actions tab
   - Click on the "Deploy PDT.AI" workflow
   - Watch the progress of the build and deployment

3. Once the workflow completes successfully, your site will be deployed to GitHub Pages

4. Your site will be available at: `https://yourusername.github.io/pdt-ai/`

## Step 6: Verify Deployment

1. Navigate to your GitHub Pages URL: `https://yourusername.github.io/pdt-ai/`

2. Test all functionality to ensure everything works correctly:
   - Home page loads with all images and content
   - Article Research section can search for articles
   - Treatment Plan calculator works properly
   - Image Analysis tools function correctly

## Troubleshooting

### Common Issues and Solutions

1. **404 Page Not Found**
   - Ensure the "homepage" field in `client/package.json` is set correctly
   - Check that the gh-pages branch exists and contains the built files
   - Verify the GitHub Pages settings in your repository

2. **API Calls Failing**
   - Check that the PUBMED_API_KEY secret is set correctly in your repository
   - For local development, ensure your `.env` file contains the correct API key

3. **Build Failures in GitHub Actions**
   - Check the error logs in the GitHub Actions tab
   - Ensure all dependencies are correctly specified in package.json
   - Verify that the Node.js version in the workflow file is compatible with your dependencies

4. **Images or Assets Not Loading**
   - Ensure all asset paths use relative URLs
   - Check that the PUBLIC_URL environment variable is set correctly during build

### Plan B: Manual Deployment

If the automated GitHub Actions deployment fails, you can deploy manually:

1. Build the project locally:
   ```bash
   npm run build
   ```

2. Install the gh-pages package if not already installed:
   ```bash
   npm install -g gh-pages
   ```

3. Deploy the build folder to GitHub Pages:
   ```bash
   gh-pages -d client/build
   ```

## Running the Full Stack Application

The GitHub Pages deployment only hosts the frontend. To run the full stack application with the backend API:

1. Clone the repository to your server or local machine

2. Install dependencies:
   ```bash
   npm run install-all
   ```

3. Create a `.env` file with your configuration

4. Build the frontend:
   ```bash
   npm run build
   ```

5. Start the full stack application:
   ```bash
   npm start
   ```

6. The application will be available at the port specified in your `.env` file (default: 5000)