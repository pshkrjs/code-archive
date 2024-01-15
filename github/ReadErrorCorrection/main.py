import sys
from collections import Counter

def get_sequences(file_name):
    '''
        Reads nucleotide sequences from given file_name returns sequences
    '''
    reads = []
    with open(file_name) as f:
        lines = f.readlines()
        for i in range(1, len(lines), 2):
            reads.append(lines[i].strip())
    return reads

def get_reverse_sequences(sequence):
    '''
        Given a nucleotide sequence returns the reverse sequence
        example:
            >>> rev = get_reverse_sequences('ACTAC')
            >>> print(rev)
            'GTAGT'
    '''
    return "".join([{"A":"T","T":"A","C":"G","G":"C"}[bp] for bp in sequence][::-1])

def get_correct_incorrect_sequences(counts, sequences):
    '''
        Given count and sequences and original sequences 
        return correct sequences(appears in the dataset at least twice (possibly as a reverse complement)) 
        and incorrect sequences(it appears in the dataset exactly once, and its Hamming distance is 1 with respect to exactly one correct read in the dataset (or its reverse complement))
    '''
    correct = []
    incorrect = []
    for count in counts:
        if counts[count] >= 2:
            correct.append(count)
        elif count in sequences:
            incorrect.append(count)
    return correct, incorrect

def get_hamming_distance(sequence1, sequence2):
    '''
        Given two sequences calculate hamming distance
        example:
            >>> hd = get_hamming_distance('ACTAC', 'ACGAG')
            >>> print(hd)
            2
    '''
    mutations = 0
    for i in range(len(sequence1)):
        if sequence1[i] != sequence2[i]:
            mutations += 1
    return mutations

def get_corrections(correct, incorrect):
    '''
        Given correct and incorrect sequences return corrections to be made to an incorrect sequence
    '''
    corrected = []
    for seq1 in incorrect:
        for seq2 in correct:
            if get_hamming_distance(seq1, seq2) == 1:
                corrected.append([seq1, seq2])
    return corrected

# read sequences
sequences = get_sequences(sys.argv[1])

# add sequences and reverse sequences to all_sequences
all_sequences = []
all_sequences.extend(sequences)
all_sequences.extend([get_reverse_sequences(sequence) for sequence in sequences])

# count number of times a sequence is present
counts = Counter(all_sequences)

# find correct and incorrrect sequences
correct, incorrect = get_correct_incorrect_sequences(counts, sequences)

# find corrections in incorrect sequences 
corrections = get_corrections(correct, incorrect)

# print corrections
for corrected_sequence in corrections:
    print(" -> ".join(corrected_sequence))
