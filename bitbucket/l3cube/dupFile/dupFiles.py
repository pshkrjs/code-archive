import os, sys
import hashlib

# Removes duplicate files
def deleteDuplicateFiles(pathsList,index):
    for path in pathsList:
        if pathsList[index] != path:
            os.remove(path)
            pathsList.remove(path)

# Scans a given folder to find Duplicate files
# duplicate files are files with identical content. Filename may be different
def findDuplicateFiles(parentFolder):
    # duplicates are stores as a dictionary { hash : [fileNames]} since
    # files that are duplicate will have the same hash
    duplicates = {}

    # os.walk to traverse the given directory
    for dirName, subdirs, fileList in os.walk(parentFolder):
        print('Traversing %s...' % dirName)
        for filename in fileList:
            # os.path.join gets the full path to the file
            path = os.path.join(dirName, filename)
            # Calculate hash
            file_hash = hashfile(path)
            # Add or append the file path
            if file_hash in duplicates:
                duplicates[file_hash].append(path)
            else:
                duplicates[file_hash] = [path]
    return duplicates


# Joins two dictionaries
def joinDicts(dictionary1, dictionary2):
    for key in dictionary2.keys():
        if key in dictionary1:
            dictionary1[key] = dictionary1[key] + dictionary2[key]
        else:
            dictionary1[key] = dictionary2[key]

# returns the HEX digest of that file present at the given path
def hashfile(path, blocksize = 65536):
    afile = open(path, 'rb')
    hasher = hashlib.md5()
    buf = afile.read(blocksize)
    while len(buf) > 0:
        hasher.update(buf)
        buf = afile.read(blocksize)
    afile.close()
    return hasher.hexdigest()

# Prints the result
def printResults(dictionary1):
    results = list(filter(lambda x: len(x) > 1, dictionary1.values()))
    if len(results) > 0:
        print('Duplicates Found:')
        print('The following files are identical. Duplicates are checked based on the content and NOT the filenames')
        print('_____________________________')
        for result in results:
            i=len(result)-1
            print('\tfilenumber\tfilename')
            for subresult in result:
                print('\t%d\t%s' % (i,subresult))
                i -= 1
            print('_____________________________')
            operation = input('Merge or delete?(m/d)')
            if operation == 'm':
                print("Merging files")
                deleteDuplicateFiles(result,0)
            elif operation == 'd':
                print("Deleting files")
                fileNo = input('Enter file number to be kept?')
                deleteDuplicateFiles(result,int(fileNo))
    else:
        print('No duplicate files found.')

if __name__ == '__main__':
    if len(sys.argv) > 1:
        duplicates = {}
        folders = sys.argv[1:]
        for i in folders:
            # Iterate the folders given
            if os.path.exists(i):
                # os.path.exists function verifies that the given folder exists in the filesystem
                # Find the duplicated files and append them to the duplicates
                joinDicts(duplicates, findDuplicateFiles(i))
            else:
                print('%s is invalid path, please check again' % i)
                sys.exit()
            printResults(duplicates)
    else:
        print('Usage: python dupFiles.py folderName or python dupFiles.py folderName1 folderName2 folderName3')
